<?php

namespace DigiTickets\VerifoneWebService\Message\NonSessionBased;

use DigiTickets\VerifoneWebService\Message\AbstractRemoteResponse;
use Omnipay\Common\Message\RequestInterface;

class PurchaseTransactionRequest extends AbstractTransactionRequest
{
    // This is just a "flag" to tell controllers that the response from this request needs to be confirmed/rejected.
    protected $shouldSendConfirmOrReject;
    /**
     * @var ConfirmRequest
     */
    protected $confirmRequest;
    /**
     * @var RejectRequest
     */
    protected $rejectRequest;

    public function setTokenRegistrationRequest(TokenRegistrationRequest $tokenRegistrationRequest)
    {
        // Register a token, and store it in the purchase request.
        $card = $this->getCard();
        $tokenRegistrationRequest->setPan($card->getNumber());
        $tokenRegistrationRequest->setExpiryDateYYMM($card->getExpiryDate('ym'));
        /**
         * @var TokenRegistrationResponse $tokenRegistrationResponse
         */
        $tokenRegistrationResponse = $tokenRegistrationRequest->send();
        if ($tokenRegistrationResponse->isSuccessful()) {
            $this->setTokenId($tokenRegistrationResponse->getTokenId());
        }
    }

    public function setConfirmRequest(ConfirmRequest $confirmRequest)
    {
        $this->confirmRequest = $confirmRequest;
    }

    public function setRejectRequest(RejectRequest $rejectRequest)
    {
        $this->rejectRequest = $rejectRequest;
    }

    public function getTxnType()
    {
        return '01';
    }

    public function getProcessingidentifier()
    {
        return '1';
    }

    public function setTokenId($value)
    {
        return $this->setParameter('tokenId', $value);
    }

    public function getTokenId()
    {
        return $this->getParameter('tokenId');
    }

    /**
     * @param RequestInterface $request
     * @param mixed $response
     * @return AbstractRemoteResponse
     */
    protected function buildResponse($request, $response)
    {
        $purchaseResponse = new PurchaseResponse($request, $response);

        // We need to send a confirm or reject message, depending on the result of the response.
        $confirmOrReject = $purchaseResponse->isSuccessful() ? $this->confirmRequest : $this->rejectRequest;
        $confirmOrReject->setTransactionId($purchaseResponse->getTransactionId());
        try {
            // We don't care about the response!
            // However, if there was a problem, eg timeout, we try once more.
            $confirmOrReject->send();
        } catch(\SoapFault $e) {
            $confirmOrReject->send();
        }

        return $purchaseResponse;
    }
}