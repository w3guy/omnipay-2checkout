<?php

namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Abstract Request.
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
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

    public function getPurchaseStep()
    {
        return $this->getParameter('purchaseStep');
    }

    public function setPurchaseStep($value)
    {
        return $this->setParameter('purchaseStep', $value);
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

    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }

    public function setPrivateKey($value)
    {
        return $this->setParameter('privateKey', $value);
    }

    /**
     * Setter: sale ID for use by refund.
     *
     * @param $value
     *
     * @return BaseAbstractRequest
     */
    public function setSaleId($value)
    {
        return $this->setParameter('saleId', $value);
    }

    /**
     * Getter: sale ID for use by refund.
     *
     * @return string
     */
    public function getSaleId()
    {
        return $this->getParameter('saleId');
    }

    /**
     * Setter: sale ID for use by refund.
     *
     * @param $value
     *
     * @return BaseAbstractRequest
     */
    public function setInvoiceId($value)
    {
        return $this->setParameter('invoiceId', $value);
    }

    /**
     * Getter: sale ID for use by refund.
     *
     * @return string
     */
    public function getInvoiceId()
    {
        return $this->getParameter('invoiceId');
    }

    /**
     * Getter: admin username for use by refund.
     *
     * @return string
     */
    public function getAdminUsername()
    {
        return $this->getParameter('adminUsername');
    }

    /**
     * Setter: admin username for use by refund.
     *
     * @param $value
     *
     * @return BaseAbstractRequest
     */
    public function setAdminUsername($value)
    {
        return $this->setParameter('adminUsername', $value);
    }

    /**
     * Getter: admin password for use by refund.
     *
     * @return string
     */
    public function getAdminPassword()
    {
        return $this->getParameter('adminPassword');
    }

    /**
     * Setter: admin password for use by refund.
     *
     * @param $value
     *
     * @return BaseAbstractRequest
     */
    public function setAdminPassword($value)
    {
        return $this->setParameter('adminPassword', $value);
    }

    /**
     * Getter: category for use by refund.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->getParameter('category');
    }

    /**
     * Setter: category for use by refund.
     *
     * @param $value
     *
     * @return BaseAbstractRequest
     */
    public function setCategory($value)
    {
        return $this->setParameter('category', $value);
    }

    /**
     * Getter: comment for use by refund.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->getParameter('comment');
    }

    /**
     * Setter: category for use by refund.
     *
     * @param $value
     *
     * @return BaseAbstractRequest
     */
    public function setComment($value)
    {
        return $this->setParameter('comment', $value);
    }

    /**
     * Setter: lineitem_id for use by stop recurring.
     *
     * @param $value
     *
     * @return BaseAbstractRequest
     */
    public function setLineItemId($value)
    {
        return $this->setParameter('lineItemId', $value);
    }

    /**
     * Getter: lineitem_id for use by stop recurring.
     *
     * @return string
     */
    public function getLineItemId()
    {
        return $this->getParameter('lineItemId');
    }

    public function getAmount()
    {
        return parent::getAmount();
    }

    public function setAmount($value)
    {
        return parent::setAmount($value);
    }

    public function getCurrency()
    {
        return parent::getCurrency();
    }

    public function setCurrency($value)
    {
        return parent::setCurrency($value);
    }
}
