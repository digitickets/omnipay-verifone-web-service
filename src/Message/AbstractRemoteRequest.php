<?php

namespace DigiTickets\VerifoneWebService\Message;

use DigiTickets\VerifoneWebService\Message\Objects\ClientHeader;
use DigiTickets\VerifoneWebService\Message\Objects\Message;
use DigiTickets\VerifoneWebService\Message\Objects\ProcessMsg;
use Omnipay\Common\Message\AbstractRequest;
use SimpleXMLElement;

/**
 * Verifone Web Service Purchase Request
 */
abstract class AbstractRemoteRequest extends AbstractRequest
{
    protected $liveEndpoint = 'TBA';
    protected $testEndpoint = 'https://txn-cst.cxmlpg.com/XML4/commideagateway.asmx';

    protected function getEndpoint(bool $withWsdl = false)
    {
        return ($this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint) . ($withWsdl ? '?WSDL' : '');
    }

    /**
     * @return string
     */
    abstract public function getMsgType();

    /**
     * @return string
     */
    abstract public function getMsgData();

    public function getSystemId()
    {
        return $this->getParameter('systemId');
    }

    public function setSystemId($value)
    {
        return $this->setParameter('systemId', $value);
    }

    public function getSystemGuid()
    {
        return $this->getParameter('systemGuid');
    }

    public function setSystemGuid($value)
    {
        return $this->setParameter('systemGuid', $value);
    }

    public function getPasscode()
    {
        return $this->getParameter('passcode');
    }

    public function setPasscode($value)
    {
        return $this->setParameter('passcode', $value);
    }

    /**
     * @return ProcessMsg
     */
    public function getData()
    {
        $this->validate('systemId', 'systemGuid', 'passcode');

        $data = new ProcessMsg(
            new Message(
                new ClientHeader(
                    $this->getSystemId(),
                    $this->getSystemGuid(),
                    $this->getPasscode(),
                    '',
                    1,
                    false,
                    ''
                ),
                $this->getMsgType(),
                $this->getMsgData()
            )
        );

        return $data;
    }

    /**
     * @param ProcessMsg $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface|Response
     */
    public function sendData($data)
    {
        $processMessage = new \SOAPClient($this->getEndpoint(true));
        $response = $processMessage->__soapCall('ProcessMsg', ['ProcessMsg' => $data]);

        return $this->response = new RemoteResponse($this, $response);
    }
}