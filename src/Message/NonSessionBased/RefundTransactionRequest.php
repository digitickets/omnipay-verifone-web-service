<?php

namespace DigiTickets\VerifoneWebService\Message\NonSessionBased;

use DigiTickets\VerifoneWebService\Message\AbstractRemoteResponse;
use Omnipay\Common\Message\RequestInterface;

class RefundTransactionRequest extends AbstractTransactionRequest
{
    public function getTxnType()
    {
        return '02';
    }

    public function getProcessingidentifier()
    {
        return '3';
    }

    /**
     * @param RequestInterface|RefundTransactionRequest $request
     * @param mixed $response
     * @return AbstractRemoteResponse
     */
    protected function buildResponse($request, $response)
    {
        $refundResponse = new RefundResponse($request, $response);

        // We need to send a confirm or reject message, depending on the result of the response.
        // Make sure we've got both request objects available.
        if (!empty($this->confirmRequest) && !empty($this->rejectRequest)) {
            $confirmOrReject = $refundResponse->isSuccessful() ? $this->confirmRequest : $this->rejectRequest;
            $confirmOrReject->setProcessingDb($refundResponse->getProcessingDb());
            if (is_callable([$confirmOrReject, 'setTokenId'])) {
                $confirmOrReject->setTokenId($request->getTokenId());
            }
            // We don't care about the response!
            $confirmOrReject->send();
        }

        return $refundResponse;
    }
}
