<?php

namespace DigiTickets\VerifoneWebService\Message\Objects;


class Message
{
    /**
     * @var ClientHeader
     */
    private $ClientHeader;
    /**
     * @var string
     */
    private $MsgType;
    /**
     * @var string
     */
    private $MsgData;

    /**
     * Message constructor.
     * @param ClientHeader $ClientHeader
     * @param string $MsgType
     * @param string $MsgData
     */
    public function __construct(
        ClientHeader $ClientHeader,
        string $MsgType,
        string $MsgData)
    {
        $this->ClientHeader = $ClientHeader;
        $this->MsgType = $MsgType;
        $this->MsgData = $MsgData;
    }
}