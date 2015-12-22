<?php

namespace Omnipay\TwoCheckoutPlus;

use Omnipay\Common\AbstractGateway;

/**
 * 2Checkout Token Gateway.
 */
class TokenGateway extends AbstractGateway
{
    public function getName()
    {
        return 'TwoCheckoutPlus_Token';
    }

    public function getDefaultParameters()
    {
        return array(
            'accountNumber' => '',
            'privateKey' => '',
            'testMode' => false,
        );
    }

    public function getAccountNumber()
    {
        return $this->getParameter('accountNumber');
    }

    public function setAccountNumber($value)
    {
        return $this->setParameter('accountNumber', $value);
    }

    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }

    public function setPrivateKey($value)
    {
        return $this->setParameter('privateKey', $value);
    }

    /**
     * @return Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\TwoCheckoutPlus\Message\TokenPurchaseRequest', $parameters);
    }
}
