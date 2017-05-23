<?php

namespace DigiTickets\VerifoneWebService\Message;

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
<vgtokenregistrationrequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="VANGUARD">
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
        return $this->getParameter('purchase');
    }

    public function getRefund()
    {
        return $this->getParameter('refund');
    }

    public function getCashback()
    {
        return $this->getParameter('cashback');
    }

    public function getTokenexpirationdate()
    {
        return $this->getParameter('tokenexpirationdate');
    }
}
