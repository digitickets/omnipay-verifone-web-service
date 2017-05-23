<?php

namespace DigiTickets\VerifoneWebService\Message;

use DigiTickets\VerifoneWebService\Message\Objects\ProcessMsg;
use DigiTickets\VerifoneWebService\Message\Objects\ProcessMsg\Message;
use DigiTickets\VerifoneWebService\Message\Objects\ProcessMsg\Message\ClientHeader;
use Omnipay\Common\Message\AbstractRequest;

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

    /**
     * @param RequestInterface $request
     * @param mixed $response
     * @return AbstractRemoteResponse
     */
    abstract protected function buildResponse($request, $response);

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

    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    public function setAccountId($value)
    {
        return $this->setParameter('accountId', $value);
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
                    empty($this->getProcessingDb()) ? '' : $this->getProcessingDb(),
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

        return $this->response = $this->buildResponse($this, $response);
    }

    public function getSessionGuid()
    {
        return $this->getParameter('sessionGuid');
    }

    public function setSessionGuid($value)
    {
        return $this->setParameter('sessionGuid', $value);
    }

    public function getProcessingDb()
    {
        return $this->getParameter('processingDb');
    }

    public function setProcessingDb($value)
    {
        return $this->setParameter('processingDb', $value);
    }
}