<?php

namespace DigiTickets\VerifoneWebService\Message\NonSessionBased;

use DigiTickets\VerifoneWebService\Message\AbstractRemoteResponse;
use DigiTickets\VerifoneWebService\Message\Objects\ProcessMsg\Message;

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

    public function getCode()
    {
        // The authcode seems to be blank, but I'm including this for completeness.
        return $this->data->getMsgDataAttribute('authcode');
    }

    public function getMessage()
    {
        return $this->data->getMsgDataAttribute('txnresult');
    }

    public function getTransactionReference()
    {
        // Build a JSON-style collection of relevant values.
        /**
         * @var Message $responseData
         */
        $responseData = $this->data;
        return json_encode([
            'merchantreference' => $responseData->getMsgDataAttribute('merchantreference'),
            'transactionid' => $responseData->getMsgDataAttribute('transactionid'),
            'tid' => $responseData->getMsgDataAttribute('tid'),
            'schemename' => $responseData->getMsgDataAttribute('schemename'),
            'messagenumber' => $responseData->getMsgDataAttribute('messagenumber'),
            'pcavsresult' => $responseData->getMsgDataAttribute('pcavsresult'),
            'ad1avsresult' => $responseData->getMsgDataAttribute('ad1avsresult'),
            'cvcresult' => $responseData->getMsgDataAttribute('cvcresult'),
            'arc' => $responseData->getMsgDataAttribute('arc'),

        ]);
    }
}
