<?php

namespace Omnipay\TwoCheckoutPlus\Message;

class NotificationRequest extends AbstractRequest
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
        return new NotificationResponse($this, $data);
    }
}
