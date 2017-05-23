<?php

namespace DigiTickets\VerifoneWebService\Message\SessionBased;

use DigiTickets\VerifoneWebService\Message\AbstractRemoteRequest;
use DigiTickets\VerifoneWebService\Message\AbstractRemoteResponse;
use Omnipay\Common\Message\RequestInterface;

class RefundRequest extends AbstractRemoteRequest
{
    /**
     * @return string
     */
    public function getMsgType()
    {
        return 'TXN';
    }

    /**
     * @return string
     */
    public function getMsgData()
    {
        return '<?xml version="1.0"?>
<transactionrequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="TXN">
</transactionrequest>';
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

    public function setHouse($value)
    {
        return $this->setParameter('house', $value);
    }

    public function getHouse()
    {
        return $this->getParameter('house');
    }

    public function setPostcode($value)
    {
        return $this->setParameter('postcode', $value);
    }

    public function getPostcode()
    {
        return $this->getParameter('postcode');
    }

    public function getPostcodeDigits()
    {
        // Remove anything in the postcode that is not a digit, and return the result.
        return preg_replace('/[^\d]/', '', $this->getPostcode());
    }

    public function setCurrencyNumber($value)
    {
        return $this->setParameter('currencyNumber', $value);
    }

    public function getCurrencyNumber()
    {
        return $this->getParameter('currencyNumber');
    }

    public function setAccountPasscode($value)
    {
        return $this->setParameter('accountPasscode', $value);
    }

    public function getAccountPasscode()
    {
        return $this->getParameter('accountPasscode');
    }

    public function getTxntype()
    {
        return '01';
    }

    public function getApacsterminalcapabilities()
    {
        return '4298';
    }

    public function getCapturemethod()
    {
        return '12';
    }

    public function getProcessingidentifier()
    {
        return '1';
    }

    public function getReturnhash()
    {
        return '0';
    }
}