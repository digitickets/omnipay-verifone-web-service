<?php

namespace DigiTickets\VerifoneWebService\Message\NonSessionBased;

use DigiTickets\VerifoneWebService\Message\AbstractRemoteResponse;
use Omnipay\Common\Message\RequestInterface;

class RefundTransactionRequest extends AbstractTransactionRequest
{
    // This is just a "flag" to tell controllers that the response from this request needs to be confirmed/rejected.
    protected $shouldSendConfirmOrReject;

    public function getTxnType()
    {
        return '02';
    }

    public function getProcessingidentifier()
    {
        return '3';
    }

    /**
     * @param RequestInterface $request
     * @param mixed $response
     * @return AbstractRemoteResponse
     */
    protected function buildResponse($request, $response)
    {
        return new RefundResponse($request, $response);
    }
}
