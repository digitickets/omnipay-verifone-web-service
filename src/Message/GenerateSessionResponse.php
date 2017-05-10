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
        // Get the error code and description.
        $errorCode = $this->data->getMsgDataAttribute('errorcode');
        $errorDescription = $this->data->getMsgDataAttribute('errordescription');
        return $errorCode == '0' ? null : $errorCode . ' - ' . $errorDescription;
    }
}