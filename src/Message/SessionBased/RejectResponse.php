<?php

namespace DigiTickets\VerifoneWebService\Message\SessionBased;

use DigiTickets\VerifoneWebService\Message\AbstractRemoteResponse;

class RejectResponse extends AbstractRemoteResponse
{
    /**
     * Return the error message
     *
     * @return string
     */
    public function getError()
    {
        return null;
    }
}