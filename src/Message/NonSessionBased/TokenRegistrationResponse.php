<?php

namespace DigiTickets\VerifoneWebService\Message\NonSessionBased;

use DigiTickets\VerifoneWebService\Message\AbstractRemoteResponse;

class TokenRegistrationResponse extends AbstractRemoteResponse
{
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

        return $msgType == 'TOKENRESPONSE' ? null : $errorCode . ' - ' . $errorDescription;
    }

    public function getTokenId()
    {
        return $this->data->getMsgDataAttribute('tokenid');
    }
}