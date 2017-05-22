<?php

namespace DigiTickets\VerifoneWebService\Message;

class GenerateSessionResponse extends AbstractRemoteResponse
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
}