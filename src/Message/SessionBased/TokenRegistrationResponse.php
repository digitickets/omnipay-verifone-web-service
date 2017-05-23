<?php

namespace DigiTickets\VerifoneWebService\Message\SessionBased;

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
        return $this->getErrorByErrorCode();
    }

    public function getTokenId()
    {
        return $this->data->getMsgDataAttribute('tokenid');
    }
}