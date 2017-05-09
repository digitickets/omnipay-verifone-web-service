<?php

namespace DigiTickets\VerifoneWebService\Message;

class GenerateSession extends AbstractRemoteRequest
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
        return '<?xml version="1.0"?><vggeneratesessionrequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="VANGUARD"><returnurl>https://www.company.com/returnurl.aspx</returnurl><fullcapture>true</fullcapture></vggeneratesessionrequest>';
    }

}