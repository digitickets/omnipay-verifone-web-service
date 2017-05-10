<?php

namespace DigiTickets\VerifoneWebService\Message\Objects\ProcessMsg;

use DigiTickets\VerifoneWebService\Message\Objects\ProcessMsg\Message\ClientHeader;

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
     * @var \SimpleXMLElement
     */
    private $MsgDataAsObject;

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

        $this->MsgDataAsObject = simplexml_load_string($this->MsgData, 'SimpleXMLElement', LIBXML_NOWARNING);
    }

    /**
     * @param string $attributeName
     * @return string
     */
    public function getMsgDataAttribute($attributeName)
    {
        return $this->MsgDataAsObject->$attributeName;
    }

    /**
     * @param string $attributeName
     * @return string|null
     */
    public function getClientHeaderAttribute($attributeName)
    {
        return $this->ClientHeader->getAttribute($attributeName);
    }
}
