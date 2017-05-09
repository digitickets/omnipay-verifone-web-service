<?php

namespace DigiTickets\VerifoneWebService\Message\Objects;

class ClientHeader
{
    /**
     * @var int
     */
    private $SystemID;
    /**
     * @var string
     */
    private $SystemGUID;
    /**
     * @var string
     */
    private $Passcode;
    /**
     * @var string
     */
    private $ProcessingDB;
    /**
     * @var int
     */
    private $SendAttempt;
    /**
     * @var bool
     */
    private $CDATAWrapping;
    /**
     * @var string
     */
    private $Source;

    /**
     * ClientHeader constructor.
     * @param int $SystemID
     * @param string $SystemGUID
     * @param string $Passcode
     * @param string $ProcessingDB
     * @param int $SendAttempt
     * @param bool $CDATAWrapping
     * @param string $Source
     */
    public function __construct(
        int $SystemID,
        string $SystemGUID,
        string $Passcode,
        string $ProcessingDB,
        int $SendAttempt,
        bool $CDATAWrapping,
        string $Source)
    {
        $this->SystemID = $SystemID;
        $this->SystemGUID = $SystemGUID;
        $this->Passcode = $Passcode;
        $this->ProcessingDB = $ProcessingDB;
        $this->SendAttempt = $SendAttempt;
        $this->CDATAWrapping = $CDATAWrapping;
        $this->Source = $Source;
    }
}