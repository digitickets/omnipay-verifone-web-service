<?php

namespace DigiTickets\VerifoneWebService\Message;

class RejectRequest extends AbstractRemoteRequest
{
    /**
     * @return string
     */
    public function getMsgType()
    {
        return 'VGREJECTIONREQUEST';
    }

    /**
     * @return string
     */
    public function getMsgData()
    {
        return '<?xml version="1.0"?>
<vgrejectionrequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="VANGUARD">
<sessionguid>'.$this->getSessionGuid().'</sessionguid>
<transactionid>'.$this->getTransactionId().'</transactionid>
<capturemethod>12</capturemethod>
</vgrejectionrequest>';
    }

    /**
     * @param RequestInterface $request
     * @param mixed $response
     * @return AbstractRemoteResponse
     */
    protected function buildResponse($request, $response)
    {
        return new RejectResponse($request, $response);
    }
}
