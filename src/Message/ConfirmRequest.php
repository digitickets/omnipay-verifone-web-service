<?php

namespace DigiTickets\VerifoneWebService\Message;

class ConfirmRequest extends AbstractRemoteRequest
{
    /**
     * @return string
     */
    public function getMsgType()
    {
        return 'VGCONFIRMATIONREQUEST';
    }

    /**
     * @return string
     */
    public function getMsgData()
    {
        $tmp = '<?xml version="1.0"?>
<vgconfirmationrequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="VANGUARD">
<sessionguid>'.$this->getSessionGuid().'</sessionguid>
<transactionid>'.$this->getTransactionId().'</transactionid>
</vgconfirmationrequest>';

        return $tmp;
    }

    /**
     * @param RequestInterface $request
     * @param mixed $response
     * @return AbstractRemoteResponse
     */
    protected function buildResponse($request, $response)
    {
        return new ConfirmResponse($request, $response);
    }

    public function getSessionGuid()
    {
        return $this->getParameter('sessionGuid');
    }

    public function setSessionGuid($value)
    {
        return $this->setParameter('sessionGuid', $value);
    }
}
