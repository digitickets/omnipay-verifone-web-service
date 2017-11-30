<?php

namespace DigiTickets\VerifoneWebService\Message\NonSessionBased;

use DigiTickets\VerifoneWebService\Message\AbstractRemoteRequest;

abstract class AbstractTransactionRequest extends AbstractRemoteRequest
{
    /**
     * @var ConfirmRequest
     */
    protected $confirmRequest;
    /**
     * @var RejectRequest
     */
    protected $rejectRequest;

    public function setConfirmRequest(ConfirmRequest $confirmRequest)
    {
        $this->confirmRequest = $confirmRequest;
    }

    public function setRejectRequest(RejectRequest $rejectRequest)
    {
        $this->rejectRequest = $rejectRequest;
    }

    /**
     * Override this method in subclasses (eg PurchaseTransactionRequest) to provide card/billing details.
     * @return string
     */
    protected function getCardElementsForTx()
    {
        return '';
    }

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
        // Note: Some of the optional elements have been omitted.
        // If added back in, make sure they're not populated for refunds.
        return '<?xml version="1.0"?>
<transactionrequest
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns="'.$this->getMsgType().'"
>
<merchantreference>'.$this->getTransactionId().'</merchantreference>
<accountid>'.$this->getAccountId().'</accountid>
<accountpasscode>'.$this->getAccountPasscode().'</accountpasscode>
<txntype>'.$this->getTxnType().'</txntype>
<transactioncurrencycode>'.$this->getCurrencyNumeric().'</transactioncurrencycode>
<terminalcountrycode>'.$this->getCurrencyNumeric().'</terminalcountrycode>
<apacsterminalcapabilities>'.$this->getApacsterminalcapabilities().'</apacsterminalcapabilities>
<capturemethod>'.$this->getCapturemethod().'</capturemethod>
<processingidentifier>'.$this->getProcessingidentifier().'</processingidentifier>
<tokenid>'.$this->getTokenId().'</tokenid>'.
        $this->getCardElementsForTx().'
<txnvalue>'.$this->getAmount().'</txnvalue>
<transactiondatetime>'.$this->getTransactiondatetime().'</transactiondatetime>
</transactionrequest>';
    }

    public function setTransactionId($value)
    {
        return $this->setParameter('transactionId', $value);
    }

    public function getTransactionId()
    {
        return $this->getParameter('transactionId');
    }

    public function setAccountPasscode($value)
    {
        return $this->setParameter('accountPasscode', $value);
    }

    public function getAccountPasscode()
    {
        return $this->getParameter('accountPasscode');
    }

    public function setSuppressCVC($value)
    {
        return $this->setParameter('SuppressCVC', !!$value);
    }

    public function getSuppressCVC()
    {
        return $this->getParameter('SuppressCVC');
    }

    public function setSuppressPCAVS($value)
    {
        return $this->setParameter('SuppressPCAVS', !!$value);
    }

    public function getSuppressPCAVS()
    {
        return $this->getParameter('SuppressPCAVS');
    }

    public function setSuppressAD1AVS($value)
    {
        return $this->setParameter('SuppressAD1AVS', !!$value);
    }

    public function getSuppressAD1AVS()
    {
        return $this->getParameter('SuppressAD1AVS');
    }

    public function setCVCFailOn($value)
    {
        return $this->setParameter('CVCFailOn', $value);
    }

    public function getCVCFailOn()
    {
        return $this->getParameter('CVCFailOn');
    }

    public function setPCAVSFailOn($value)
    {
        return $this->setParameter('PCAVSFailOn', $value);
    }

    public function getPCAVSFailOn()
    {
        return $this->getParameter('PCAVSFailOn');
    }

    public function setAD1AVSFailOn($value)
    {
        return $this->setParameter('AD1AVSFailOn', $value);
    }

    public function getAD1AVSFailOn()
    {
        return $this->getParameter('AD1AVSFailOn');
    }

    abstract public function getTxnType();

    public function getApacsterminalcapabilities()
    {
        return '4298';
    }

    public function getCapturemethod()
    {
        return '12';
    }

    abstract public function getProcessingidentifier();

    public function setTransactionReference($value)
    {
        // This is a JSON object (converted to a string). One property is "tokenId".
        return $this->setParameter('transactionReference', $value);
    }

    public function getTokenId()
    {
        $transactionReference = $this->getParameter('transactionReference');
        $txRefAsJson = json_decode($transactionReference, true);

        return $txRefAsJson['tokenId'];
    }

    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }

    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    public function getTransactiondatetime()
    {
        // Return current time in the format "dd/mm/yyyy hh:mm:ss".
        $now = new \DateTime();

        return $now->format('d/m/Y h:i:s');
    }
}
