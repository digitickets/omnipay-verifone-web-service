<?php

namespace DigiTickets\VerifoneWebService\Message\NonSessionBased;

use DigiTickets\VerifoneWebService\Message\AbstractRemoteResponse;
use Omnipay\Common\Message\RequestInterface;

class PurchaseTransactionRequest extends AbstractTransactionRequest
{
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

    protected function getPostcodeDigits($postcode)
    {
        // Remove anything in the postcode that is not a digit, and return the result.
        return preg_replace('/[^\d]/', '', $postcode);
    }

    protected function getCardElementsForTx()
    {
        $card = $this->getCard();

        return
'
<csc>'.$card->getCvv().'</csc>
<avspostcode>'.$this->getPostcodeDigits($card->getBillingPostcode()).'</avspostcode>
<issuenumber>'.$card->getIssueNumber().'</issuenumber>
<expirydate>'.$card->getExpiryDate('ym').'</expirydate>
<startdate>'.$card->getStartDate('my').'</startdate>
';
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
        // Make sure we've got both request objects available.
        if (!empty($this->confirmRequest) && !empty($this->rejectRequest)) {
            $confirmOrReject = $purchaseResponse->isSuccessful() ? $this->confirmRequest : $this->rejectRequest;
            $confirmOrReject->setTransactionId($purchaseResponse->getTransactionId());
            try {
                // We don't care about the response!
                // However, if there was a problem, eg timeout, we try once more.
                $confirmOrReject->send();
            } catch (\SoapFault $e) {
                $confirmOrReject->send();
            }
        }

        return $purchaseResponse;
    }
}
