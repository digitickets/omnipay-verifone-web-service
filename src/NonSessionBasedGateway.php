<?php

namespace DigiTickets\VerifoneWebService;

class NonSessionBasedGateway extends AbstractVerifoneGateway
{
    public function tokenRegistration(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\NonSessionBased\TokenRegistrationRequest',
            $parameters
        );
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\NonSessionBased\PurchaseTransactionRequest',
            $parameters
        );
    }

    public function confirm(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\NonSessionBased\ConfirmRequest',
            $parameters
        );
    }

    public function reject(array $parameters = array())
    {
        return $this->createRequest(
            '\DigiTickets\VerifoneWebService\Message\NonSessionBased\RejectRequest',
            $parameters
        );
    }
}