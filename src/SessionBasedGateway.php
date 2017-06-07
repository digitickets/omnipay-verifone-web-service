<?php

namespace DigiTickets\VerifoneWebService;

class SessionBasedGateway extends AbstractVerifoneGateway
{
    public function getCardFormPostUrl()
    {
        return ($this->getTestMode() ? $this->testCardFormPostUrl : $this->liveCardFormPostUrl);
    }

    public function generateSession(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\SessionBased\GenerateSessionRequest',
            $parameters
        );
    }

    public function getCardDetails(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\SessionBased\GetCardDetailsRequest',
            $parameters
        );
    }

    public function tokenRegistration(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\SessionBased\TokenRegistrationRequest',
            $parameters
        );
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\SessionBased\PurchaseRequest',
            $parameters
        );
    }

    public function confirm(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\SessionBased\ConfirmRequest',
            $parameters
        );
    }

    public function reject(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\SessionBased\RejectRequest',
            $parameters
        );
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\NonSessionBased\RefundTransactionRequest',
            $parameters
        );
    }

    public function confirmRefundRequest(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\NonSessionBased\ConfirmRequest',
            $parameters
        );
    }

    public function rejectRefundRequest(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\NonSessionBased\RejectRequest',
            $parameters
        );
    }
}
