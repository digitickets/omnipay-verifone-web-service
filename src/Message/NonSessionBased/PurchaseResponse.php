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
        $errorCode = $this->data->getMsgDataAttribute('CODE');
        $errorDescription = $this->data->getMsgDataAttribute('MSGTXT');

        return $msgType == 'TRM' ? null : $errorCode . ' - ' . $errorDescription;
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
        return $this->data->getMsgDataAttribute('authmessage');
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
}