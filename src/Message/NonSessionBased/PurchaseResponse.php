<?php

namespace DigiTickets\VerifoneWebService\Message\NonSessionBased;

use DigiTickets\VerifoneWebService\Message\AbstractRemoteResponse;

class PurchaseResponse extends AbstractRemoteResponse
{
    const REJECTED_RESULTS = ['REFERRAL', 'DECLINED', 'COMMSDOWN'];
    private $tokenId;

    /**
     * Return the error message
     *
     * @return string
     */
    public function getError()
    {
        $failMessage = 'Your transaction was unsuccessful. Please try again';

        // See if it was rejected outright.
        $txnResult = $this->data->getMsgDataAttribute('txnresult');
        if (in_array($txnResult, self::REJECTED_RESULTS)) {
            return $failMessage;
        }

        // Now see if any additional checks failed, and whether the config says to fail the tx if they did.
        /**
         * @var PurchaseTransactionRequest $request
         */
        $request = $this->getRequest();
        if ($request->getCVCFailOn() && $this->failAdditionalCheck('cvcresult', $request->getCVCFailOn())) {
            return $failMessage;
        }
        if ($request->getAD1AVSFailOn() && $this->failAdditionalCheck('ad1avsresult', $request->getAD1AVSFailOn())) {
            return $failMessage;
        }
        if ($request->getPCAVSFailOn() && $this->failAdditionalCheck('pcavsresult', $request->getPCAVSFailOn())) {
            return $failMessage;
        }

        // Could not detect any errors.
        return null;
    }

    private function failAdditionalCheck(string $attribute, string $failOnCsl)
    {
        $additionalResultMapping = [
            0 => 'notProvided',
            1 => 'notChecked',
            2 => 'matched',
            4 => 'notMatched',
            8 => 'partialMatch'
        ];
        if (!array_key_exists($this->data->getMsgDataAttribute($attribute), $additionalResultMapping)) {
            // We don't recognise the error code.
            return true;
        }
        $resultString = $additionalResultMapping[$this->data->getMsgDataAttribute($attribute)];
        $failOn = explode(',', $failOnCsl);

        return in_array($resultString, $failOn);
    }

    public function getTransactionId()
    {
        return $this->data->getMsgDataAttribute('transactionid');
    }

    public function setTokenId($value)
    {
        $this->tokenId = $value;
    }

    public function getMessage()
    {
        $error = $this->getError();
        return is_null($error) ? $this->getAuthMessage() : $error;
    }

    public function getTransactionReference()
    {
        return json_encode([
            'transactionId' => $this->getTransactionId(),
            'tokenId' => $this->request->getTokenId()
        ]);
    }

    public function getAuthCode()
    {
        return $this->data->getMsgDataAttribute('authcode');
    }

    public function getAuthMessage()
    {
        return $this->data->getMsgDataAttribute('authmessage');
    }
}
