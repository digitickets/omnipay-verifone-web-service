<?php

namespace DigiTickets\VerifoneWebService\Message\NonSessionBased;

use DigiTickets\VerifoneWebService\Message\AbstractRemoteResponse;

class RefundResponse extends AbstractRemoteResponse
{
    /**
     * Return the error message
     *
     * @return string
     */
    public function getError()
    {
        // Get the transaction result and auth message.
        $txnResult = $this->data->getMsgDataAttribute('txnresult');
        $authmessage = $this->data->getMsgDataAttribute('authmessage');

        return $txnResult == 'APPROVED' ? null : $authmessage;
    }

    public function getTransactionId()
    {
        return $this->data->getMsgDataAttribute('transactionid');
    }
}