<?php

namespace DigiTickets\VerifoneWebService\Message\NonSessionBased;

use DigiTickets\VerifoneWebService\Message\AbstractRemoteRequest;
use DigiTickets\VerifoneWebService\Message\AbstractRemoteResponse;
use Omnipay\Common\Message\RequestInterface;

class RefundTransactionRequest extends AbstractTransactionRequest
{
    // This is just a "flag" to tell controllers that the response from this request needs to be confirmed/rejected.
    protected $shouldSendConfirmOrReject;

    /**
     * @param RequestInterface $request
     * @param mixed $response
     * @return AbstractRemoteResponse
     */
    protected function buildResponse($request, $response)
    {
        return new RefundResponse($request, $response);
    }

    public function getTxnType()
    {
        return '02';
    }

    public function getApacsterminalcapabilities()
    {
        return '4290';
    }

    public function getCapturemethod()
    {
        return '11';
    }

    public function getProcessingidentifier()
    {
        return '3';
    }
}
