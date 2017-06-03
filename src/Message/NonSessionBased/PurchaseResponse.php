<?php

namespace DigiTickets\VerifoneWebService\Message\NonSessionBased;

use DigiTickets\VerifoneWebService\Message\AbstractRemoteResponse;

class PurchaseResponse extends AbstractRemoteResponse
{
    private $tokenId;

    /**
     * Return the error message
     *
     * @return string
     */
    public function getError()
    {
        $msgType = $this->data->getMsgType();

        return $msgType == 'TRM' ? null : 'Your transaction was unsuccessful. Please try again';
    }

    public function getTransactionId()
    {
        return $this->data->getMsgDataAttribute('transactionid');
    }

    public function setTokenId($value)
    {
        $this->tokenId = $value;
    }

    public function getMessage()
    {
        $error = $this->getError();
        return is_null($error) ? $this->getAuthMessage() : $error;
    }

    public function getTransactionReference()
    {
        return json_encode([
            'transactionId' => $this->getTransactionId(),
            'tokenId' => $this->request->getTokenId()
        ]);
    }

    public function getAuthCode()
    {
        return $this->data->getMsgDataAttribute('authcode');
    }

    public function getAuthMessage()
    {
        return $this->data->getMsgDataAttribute('authmessage');
    }

}