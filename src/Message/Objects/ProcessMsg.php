<?php

namespace DigiTickets\VerifoneWebService\Message\Objects;

use DigiTickets\VerifoneWebService\Message\Objects\ProcessMsg\Message;

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

    /**
     * @return string
     */
    public function getMsgType()
    {
        return $this->Message->getMsgType();
    }

    /**
     * @param string $attributeName
     * @return string
     */
    public function getMsgDataAttribute($attributeName)
    {
        return $this->Message->getMsgDataAttribute($attributeName);
    }

    /**
     * @return string|null
     */
    public function getProcessingDb()
    {
        return $this->Message->getClientHeaderAttribute('ProcessingDB');
    }
}