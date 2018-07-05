<?php

namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\AbstractResponse;

class NotificationResponse extends AbstractResponse implements NotificationInterface
{
    /**
     * Is the notification hash correct after validation?
     */
    public function isSuccessful()
    {
        // Validate the Hash
        $hashSecretWord = isset($this->data['secretWord'])    ? $this->data['secretWord']    : ''; // Input your secret word
        $hashSid        = isset($this->data['accountNumber']) ? $this->data['accountNumber'] : ''; // Input your seller ID (2Checkout account number)
        $hashOrder      = isset($this->data['sale_id'])       ? $this->data['sale_id']       : '';
        $hashInvoice    = isset($this->data['invoice_id'])    ? $this->data['invoice_id']    : '';
	    $md5_hash       = isset($this->data['md5_hash'])      ? $this->data['md5_hash']      : '';
        $StringToHash   = strtoupper(md5($hashOrder.$hashSid.$hashInvoice.$hashSecretWord));
		
        return $StringToHash == $md5_hash;
    }

    /**
     * 2Checkout transaction reference.
     *
     * @return mixed
     */
    public function getTransactionReference()
    {
        return isset($this->data['sale_id']) ? $this->data['sale_id'] : '';
    }

    /**
     * Order or transaction ID.
     *
     * @return mixed
     */
    public function getTransactionId()
    {
        return isset($this->data['vendor_order_id']) ? $this->data['vendor_order_id'] : '';
    }

    /**
     * Indicate what type of 2Checkout notification this is.
     *
     * @return string
     */
    public function getNotificationType()
    {
        return isset($this->data['message_type']) ? $this->data['message_type'] : '';
    }

    /**
     * Get transaction/notification status.
     *
     * SInce this is an IPN notification, we made this true.
     *
     * @return bool
     */
    public function getTransactionStatus()
    {
        return true;
    }

    /**
     * Notification response.
     *
     * @return mixed
     */
    public function getMessage()
    {
        return $this->data;
    }
}
