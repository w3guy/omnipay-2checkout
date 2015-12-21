<?php

namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Response.
 */
class TokenPurchaseResponse extends AbstractResponse implements ResponseInterface
{
    public function isSuccessful()
    {
        $responseCode = $this->data['response']['responseCode'];

        return isset($responseCode) ? $responseCode == 'APPROVED' : false;
    }

    public function isRedirect()
    {
        return false;
    }

    public function getCode()
    {
        return isset($this->data['exception']) ? $this->data['exception']['errorCode'] : null;
    }

    public function getMessage()
    {
        return isset($this->data['exception']) ? $this->data['exception']['errorMsg'] : null;
    }

    public function getTransactionReference()
    {
        return isset($this->data['response']['transactionId']) ? $this->data['response']['transactionId'] : null;
    }
}
