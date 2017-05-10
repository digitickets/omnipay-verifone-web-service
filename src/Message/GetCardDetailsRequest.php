<?php

namespace DigiTickets\VerifoneWebService\Message;

class GetCardDetailsRequest extends AbstractRemoteRequest
{
    /**
     * @return string
     */
    public function getMsgType()
    {
        return 'VGGETCARDDETAILSREQUEST';
    }

    /**
     * @return string
     */
    public function getMsgData()
    {
        return
            '<?xml version="1.0"?><vggetcarddetailsrequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="VANGUARD"><sessionguid>'.
            $this->getSessionGuid().
            '</sessionguid></vggetcarddetailsrequest>';
    }

    /**
     * @param RequestInterface $request
     * @param mixed $response
     * @return AbstractRemoteResponse
     */
    protected function buildResponse($request, $response)
    {
        return new GetCardDetailsResponse($request, $response);
    }
}