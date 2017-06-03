<?php

namespace DigiTickets\VerifoneWebService\Message\NonSessionBased;

use DigiTickets\VerifoneWebService\Message\AbstractRemoteResponse;
use Omnipay\Common\Message\RequestInterface;

class PurchaseTransactionRequest extends AbstractTransactionRequest
{
    // This is just a "flag" to tell controllers that the response from this request needs to be confirmed/rejected.
    protected $shouldSendConfirmOrReject;

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
        return new PurchaseResponse($request, $response);
    }
}