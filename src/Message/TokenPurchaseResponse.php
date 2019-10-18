<?php

namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Response.
 */
class TokenPurchaseResponse extends AbstractResponse implements ResponseInterface
{
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isSuccessful()
    {
        $responseCode = $this->data['response']['responseCode'] ?? null;

        return $responseCode === 'APPROVED';
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isRedirect()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     *
     * @return int|null
     */
    public function getCode()
    {
        return isset($this->data['exception']) ? $this->data['exception']['errorCode'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return isset($this->data['exception']) ? $this->data['exception']['errorMsg'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionReference()
    {
        return $this->data['response']['orderNumber'] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionId()
    {
        return $this->data['response']['merchantOrderId'] ?? null;
    }
}
