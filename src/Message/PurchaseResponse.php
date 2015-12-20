<?php

namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Response.
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    protected $liveEndpoint = 'https://www.2checkout.com/checkout/purchase';
    protected $testEndpoint = 'https://sandbox.2checkout.com/checkout/purchase';

    public function getEndPoint()
    {
        if ($this->data['sandbox']) {
            return $this->testEndpoint;
        } else {
            return $this->liveEndpoint;
        }
    }

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        $endpoint = $this->getEndPoint();

        // remove the sandbox parameter.
        unset($this->data['sandbox']);

        $url = $endpoint.'?'.http_build_query($this->data);

        // Fix for some sites that encode the entities
        return str_replace('&amp;', '&', $url);
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectData()
    {
        return;
    }
}
