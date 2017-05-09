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
        $processMessage = new \SOAPClient('https://txn-cst.cxmlpg.com/XML4/commideagateway.asmx?WSDL');
        $response = $processMessage->__soapCall('ProcessMsg', ['ProcessMsg' => $data]);

        return $this->response = new PurchaseResponse($this, $response);
    }

    /**
     * Method to return the value of the postdata field in the form that is submitted to Verifone.
     * It's very complicated! It is XML, with another XML document embedded in one of the elements,
     * and then it's double-encoded.
     *
     * @return string
     */
    protected function getOuterXml()
    {
        // Build the post data, which contains the request data.
        $postDataXml = new SimpleXMLElement(
            '<?xml version="1.0" encoding="utf-8"?><soap:Envelope/>'
        );
        $postDataXml->addAttribute(
            'xmlns:xsi',
            'http://www.w3.org/2001/XMLSchema-instance'
        );
        $postDataXml->addAttribute(
            'xmlns:xsd',
            'http://www.w3.org/2001/XMLSchema'
        );
        $postDataXml->addAttribute(
            'xmlns:soap',
            'http://schemas.xmlsoap.org/soap/envelope/'
        );

        $postData = $postDataXml->asXML();

        return $postData;
    }
}