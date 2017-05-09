<?php

namespace DigiTickets\VerifoneWebService\Message\Objects;

class ProcessMsg
{
    /**
     * @var Message
     */
    private $Message;

    /**
     * ProcessMsg constructor.
     * @param Message $Message
     */
    public function __construct(Message $Message)
    {
        $this->Message = $Message;
    }
}