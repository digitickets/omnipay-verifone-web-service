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
        // Determine the error message (if any).
        $txnresult = $this->data->getMsgDataAttribute('txnresult');
        $authcode = $this->data->getMsgDataAttribute('authcode');
        $authmessage = $this->data->getMsgDataAttribute('authmessage');
        return $txnresult == 'AUTHORISED' && !empty($authcode) ? null : $authmessage;
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