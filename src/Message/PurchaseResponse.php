<?php

namespace DigiTickets\VerifoneWebService\Message;

class PurchaseResponse extends AbstractRemoteResponse
{
    protected $tokenId;

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
        return (string) $this->data->getMsgDataAttribute('transactionid');
    }

    public function getMessage()
    {
        return $this->data->getMsgDataAttribute('authmessage');
    }

    public function getTransactionReference()
    {
        return json_encode([
            'transactionId' => $this->getTransactionId(),
            'tokenId' => $this->getTokenId()
        ]);
    }

    public function getAuthCode()
    {
        return $this->data->getMsgDataAttribute('authcode');
    }

    public function setTokenId($value)
    {
        $this->tokenId = $value;
    }

    protected function getTokenId()
    {
        return (string) $this->tokenId;
    }
}