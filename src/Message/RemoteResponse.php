<?php

namespace DigiTickets\VerifoneWebService\Message;

use DigiTickets\VerifoneWebService\Message\Objects\ClientHeader;
use DigiTickets\VerifoneWebService\Message\Objects\Message;
use DigiTickets\VerifoneWebService\Message\Objects\ProcessMsg;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

class RemoteResponse extends AbstractResponse
{
    /**
     * @var ProcessMsg $data
     */

    /**
     * Constructor
     *
     * @param RequestInterface $request the initiating request.
     * @param mixed $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        $this->data = $this->convertDataToProcessMsg();
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        // @TODO: Need to look in the response data to find out if it was successful.
        return true;
    }

    protected function convertDataToProcessMsg()
    {
        // $this->data starts off as an instance of stdClass. We are going to convert it into an instance of
        // ProcessMsg, which of course is a hierarchy of objects.
        if (isset($this->data->ProcessMsgResult)) {
            return new ProcessMsg($this->convertDataToMessage($this->data->ProcessMsgResult));
        }
        throw new \RuntimeException('Invalid data returned in response');
    }

    protected function convertDataToMessage(\stdClass $processMsgResult)
    {
        if (isset($processMsgResult->ClientHeader) &&
            isset($processMsgResult->MsgType) &&
            isset($processMsgResult->MsgData)) {
            return new Message(
                $this->convertDataToClientHeader($processMsgResult->ClientHeader),
                $processMsgResult->MsgType,
                $processMsgResult->MsgData
            );
        }
        throw new \RuntimeException('Invalid data returned in ProcessMsgResult');
    }

    protected function convertDataToClientHeader(\stdClass $clientHeader)
    {
        if (isset($clientHeader->SystemID) &&
            isset($clientHeader->SystemGUID) &&
            isset($clientHeader->Passcode) &&
            isset($clientHeader->ProcessingDB) &&
            isset($clientHeader->SendAttempt) &&
            isset($clientHeader->CDATAWrapping) &&
            isset($clientHeader->Source)) {
            return new ClientHeader(
                $clientHeader->SystemID,
                $clientHeader->SystemGUID,
                $clientHeader->Passcode,
                $clientHeader->ProcessingDB,
                $clientHeader->SendAttempt,
                $clientHeader->CDATAWrapping,
                $clientHeader->Source
            );
        }
        throw new \RuntimeException('Invalid data returned in ClientHeader');
    }

    public function getSessionGuid()
    {
        return $this->data->getMsgDataAttribute('sessionguid');
    }

    public function getSessionPasscode()
    {
        return $this->data->getMsgDataAttribute('sessionpasscode');
    }

    public function getProcessingDb()
    {
        return $this->data->getProcessingDb();
    }
}