<?php

namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Response.
 */
class RefundResponse extends AbstractResponse implements ResponseInterface
{
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->data['response_code']) ? $this->data['response_code'] == 'OK' : false;
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
        return isset($this->data['response_code']) ? $this->data['response_code'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return isset($this->data['response_message']) ?
            $this->data['response_message'] :
            json_encode($this->data['errors']);
    }

    /**
     * Return the first error message in the error basket.
     */
    public function getFirstErrorMessage()
    {
        return $this->data['errors'][0]['message'];
    }

    /**
     * Return the first error message in the error basket.
     */
    public function getFirstErrorCode()
    {
        return $this->data['errors'][0]['code'];
    }
}
