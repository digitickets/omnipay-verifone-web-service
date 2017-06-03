<?php

namespace DigiTickets\VerifoneWebService\Message;

use DigiTickets\VerifoneWebService\Message\Objects\ProcessMsg;
use DigiTickets\VerifoneWebService\Message\Objects\ProcessMsg\Message;
use DigiTickets\VerifoneWebService\Message\Objects\ProcessMsg\Message\ClientHeader;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

abstract class AbstractRemoteResponse extends AbstractResponse
{
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
        return empty($this->getError());
    }

    /**
     * Return the error message
     *
     * @return string
     */
    abstract public function getError();

    /**
     * Return the error message by looking at the error code & description
     *
     * @return string
     */
    protected function getErrorByErrorCode()
    {
        // Get the error code and description.
        $errorCode = $this->data->getMsgDataAttribute('errorcode');
        $errorDescription = $this->data->getMsgDataAttribute('errordescription');
        return $errorCode == '0' ? null : $errorCode . ' - ' . $errorDescription;
    }

    /**
     * Return the error message by looking at the auth code & message.
     *
     * @return string
     */
    protected function getErrorByAuthCode()
    {
        // Determine the error message (if any).
        // From Verifone Tech support: Successful transactions will respond with an auth code, auth message, and
        // other fields, however unsuccessful transactions will return with an error code and error description.
        // They also say to use a generic error message ("Your transaction was unsuccessful"), rather than trying
        // to build a message from the response.
        $authcode = $this->data->getMsgDataAttribute('authcode');
        $authmessage = $this->data->getMsgDataAttribute('authmessage');
        return !empty($authcode) && !empty($authmessage) ? null : 'Your transaction was unsuccessful. Please try again';
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