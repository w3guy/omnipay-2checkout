<?php

namespace Omnipay\TwoCheckoutPlus;

use Omnipay\Common\AbstractGateway;

/**
 * 2Checkout Gateway.
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'TwoCheckoutPlus';
    }

    public function getDefaultParameters()
    {
        return array(
            'accountNumber' => '',
            'secretWord' => '',
            // if true, transaction with the live checkout URL will be a demo sale and card won't be charged.
            'demoMode' => false,
            'testMode' => false,
        );
    }

    public function getCart()
    {
        return $this->getParameter('cart');
    }

    public function setCart($value)
    {
        return $this->setParameter('cart', $value);
    }

    public function getDemoMode()
    {
        return $this->getParameter('demoMode');
    }

    public function setDemoMode($value)
    {
        return $this->setParameter('demoMode', $value);
    }

    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    public function getCoupon()
    {
        return $this->getParameter('coupon');
    }

    public function setCoupon($value)
    {
        return $this->setParameter('coupon', $value);
    }

    public function getAccountNumber()
    {
        return $this->getParameter('accountNumber');
    }

    public function setAccountNumber($value)
    {
        return $this->setParameter('accountNumber', $value);
    }

    public function getSecretWord()
    {
        return $this->getParameter('secretWord');
    }

    public function setSecretWord($value)
    {
        return $this->setParameter('secretWord', $value);
    }

    /**
     * @return Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\TwoCheckoutPlus\Message\PurchaseRequest', $parameters);
    }

    /**
     * @return Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\TwoCheckoutPlus\Message\CompletePurchaseRequest', $parameters);
    }

    /**
     * @return Message\FraudStatusChangeRequest
     */
    public function acceptNotification(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\TwoCheckoutPlus\Message\FraudStatusChangeRequest', $parameters);
    }
}
