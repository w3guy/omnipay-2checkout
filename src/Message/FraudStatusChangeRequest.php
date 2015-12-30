<?php

namespace Omnipay\TwoCheckoutPlus\Message;

class FraudStatusChangeRequest extends AbstractRequest
{
    public function getData()
    {
        $data = $this->httpRequest->request->all();
        $data['secretWord'] = $this->getSecretWord();
        $data['accountNumber'] = $this->getAccountNumber();

        return $data;
    }

    public function sendData($data)
    {
        return new FraudStatusChangeResponse($this, $data);
    }
}
