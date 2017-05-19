<?php

namespace DigiTickets\VerifoneWebService\Message;

class PurchaseRequest extends AbstractRemoteRequest
{
    // This is just a "flag" to tell controllers that the response from this request needs to be confirmed/rejected.
    protected $sendConfirmOrReject;

    /**
     * @return string
     */
    public function getMsgType()
    {
        return 'VGTRANSACTIONREQUEST';
    }

    /**
     * @return string
     */
    public function getMsgData()
    {
        $tmp = '<?xml version="1.0"?>
<vgtransactionrequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="VANGUARD">
<sessionguid>'.$this->getSessionGuid().'</sessionguid>
<merchantreference>'.$this->getTransactionId().'</merchantreference>
<accountid>'.$this->getAccountId().'</accountid>
<txntype>01</txntype>
<transactioncurrencycode>'.$this->getCurrencyNumber().'</transactioncurrencycode>
<apacsterminalcapabilities>4298</apacsterminalcapabilities>
<capturemethod>12</capturemethod>
<processingidentifier>1</processingidentifier>
<avshouse>'.$this->getHouse().'</avshouse>
<avspostcode>'.str_replace(' ', '', $this->getPostcodeDigits()).'</avspostcode>
<txnvalue>'.$this->getAmount().'</txnvalue>
<terminalcountrycode>'.$this->getCurrencyNumber().'</terminalcountrycode>
<accountpasscode>'.$this->getAccountPasscode().'</accountpasscode>
<returnhash>0</returnhash>
</vgtransactionrequest>';

        return $tmp;
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

    public function getAccountPasscode()
    {
        return $this->getParameter('accountPasscode');
    }

    public function setAccountPasscode($value)
    {
        return $this->setParameter('accountPasscode', $value);
    }
}
