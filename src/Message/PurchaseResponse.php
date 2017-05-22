<?php

namespace DigiTickets\VerifoneWebService\Message;

class PurchaseResponse extends AbstractRemoteResponse
{
    /**
     * Return the error message
     *
     * @return string
     */
    public function getError()
    {
        return $this->getErrorByAuthCode();
    }

    public function getTransactionId()
    {
        return $this->data->getMsgDataAttribute('transactionid');
    }

    public function getMessage()
    {
        return $this->data->getMsgDataAttribute('authmessage');
    }

    public function getTransactionReference()
    {
        return $this->getTransactionId();
    }

    public function getAuthCode()
    {
        return $this->data->getMsgDataAttribute('authcode');
    }
}