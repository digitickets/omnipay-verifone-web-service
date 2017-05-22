<?php

namespace DigiTickets\VerifoneWebService\Message;

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