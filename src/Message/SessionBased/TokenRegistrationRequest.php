<?php

namespace DigiTickets\VerifoneWebService\Message\SessionBased;

use DigiTickets\VerifoneWebService\Message\AbstractRemoteRequest;
use DigiTickets\VerifoneWebService\Message\AbstractRemoteResponse;
use Omnipay\Common\Message\RequestInterface;

class TokenRegistrationRequest extends AbstractRemoteRequest
{
    /**
     * @return string
     */
    public function getMsgType()
    {
        return 'VGTOKENREGISTRATIONREQUEST';
    }

    /**
     * @return string
     */
    public function getMsgData()
    {
        return '<?xml version="1.0"?>
<vgtokenregistrationrequest
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns="VANGUARD"
>
<sessionguid>'.$this->getSessionGuid().'</sessionguid>
<merchantreference>'.$this->getTransactionId().'</merchantreference>
<expirydate>'.$this->getExpiryDateYYMM().'</expirydate>
<startdate />
<issueno />
<purchase>'.$this->getPurchase().'</purchase>
<refund>'.$this->getRefund().'</refund>
<cashback>'.$this->getCashback().'</cashback>
<tokenexpirationdate>'.$this->getTokenexpirationdate().'</tokenexpirationdate>
</vgtokenregistrationrequest>';
    }

    /**
     * @param RequestInterface $request
     * @param mixed $response
     * @return AbstractRemoteResponse
     */
    protected function buildResponse($request, $response)
    {
        return new TokenRegistrationResponse($request, $response);
    }

    public function setExpiryDateYYMM($value)
    {
        return $this->setParameter('expiryDateYYMM', $value);
    }

    public function getExpiryDateYYMM()
    {
        return $this->getParameter('expiryDateYYMM');
    }

    public function getPurchase()
    {
        return 'true';
    }

    public function getRefund()
    {
        return 'true';
    }

    public function getCashback()
    {
        return 'false';
    }

    public function getTokenexpirationdate()
    {
        // The default lifetime for a token is a fairly arbitrary 2 years.
        $today = new \DateTime();
        $twoYearsHence = $today->add(new \DateInterval('P2Y'))->format('dmY');

        return $twoYearsHence;
    }
}
