<?php

namespace DigiTickets\VerifoneWebService\Message;

class GenerateSessionRequest extends AbstractRemoteRequest
{
    /**
     * @return string
     */
    public function getMsgType()
    {
        return 'VGGENERATESESSIONREQUEST';
    }

    /**
     * @return string
     */
    public function getMsgData()
    {
        return
            '<?xml version="1.0"?><vggeneratesessionrequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="VANGUARD"><returnurl>'.
            $this->getParameter('returnUrl').
            '</returnurl><fullcapture>true</fullcapture></vggeneratesessionrequest>';
    }

    /**
     * @param RequestInterface $request
     * @param mixed $response
     * @return AbstractRemoteResponse
     */
    protected function buildResponse($request, $response)
    {
        return new GenerateSessionResponse($request, $response);
    }

    /**
     * @param string $returnUrl
     */
    public function setCardFormReturnUrl($returnUrl)
    {
        $this->setParameter('returnUrl', $returnUrl);
    }
}