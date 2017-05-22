<?php

namespace DigiTickets\VerifoneWebService;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    protected $liveCardFormPostUrl = 'TBA';
    protected $testCardFormPostUrl = 'https://vg-cst.cxmlpg.com/vanguard.aspx';

    public function getCardFormPostUrl()
    {
        return ($this->getTestMode() ? $this->testCardFormPostUrl : $this->liveCardFormPostUrl);
    }

    public function getName()
    {
        return 'Verifone (Web Service)';
    }

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

    public function generateSession(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\GenerateSessionRequest',
            $parameters
        );
    }

    public function getCardDetails(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\GetCardDetailsRequest',
            $parameters
        );
    }

    public function tokenRegistration(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\TokenRegistrationRequest',
            $parameters
        );
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\PurchaseRequest',
            $parameters
        );
    }

    public function confirm(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\ConfirmRequest',
            $parameters
        );
    }

    public function reject(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\RejectRequest',
            $parameters
        );
    }
}