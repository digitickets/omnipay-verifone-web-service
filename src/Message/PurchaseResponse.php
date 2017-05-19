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
        // From Verifone Tech support: Successful transactions will respond with an auth code, auth message, and
        // other fields, however unsuccessful transactions will return with an error code and error description.
        // They also say to use a generic error message ("Your transaction was unsuccessful"), rather than trying
        // to build a message from the response.
        $authcode = $this->data->getMsgDataAttribute('authcode');
        $authmessage = $this->data->getMsgDataAttribute('authmessage');
        return !empty($authcode) && !empty($authmessage) ? null : 'Your transaction was unsuccessful. Please try again';
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