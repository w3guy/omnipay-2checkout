<?php

namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\AbstractResponse;

class FraudStatusChangeResponse extends AbstractResponse implements NotificationInterface
{
    /**
     * Is the order specified by the notification successful?
     * i.e did it pass fraud review?
     */
    public function isSuccessful()
    {
        return $this->getTransactionStatus() == self::STATUS_COMPLETED;
    }

    /**
     * 2Checkout transaction reference.
     *
     * @return mixed
     */
    public function getTransactionReference()
    {
        return $this->data['sale_id'];
    }

    /**
     * Order or transaction ID.
     *
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->data['vendor_order_id'];
    }

    /**
     * Get transaction status.
     *
     * @return string|null
     */
    public function getTransactionStatus()
    {
        if ('FRAUD_STATUS_CHANGED' == $this->notificationType()) {

            # Validate the Hash
            $hashSecretWord = $this->data['secretWord']; # Input your secret word
            $hashSid = $this->data['accountNumber']; #Input your seller ID (2Checkout account number)
            $hashOrder = $this->data['sale_id'];
            $hashInvoice = $this->data['invoice_id'];
            $StringToHash = strtoupper(md5($hashOrder.$hashSid.$hashInvoice.$hashSecretWord));

            if ($this->data['fraud_status'] == 'pass' && $StringToHash == $this->data['md5_hash']) {
                $status = self::STATUS_COMPLETED;
            } else {
                $status = self::STATUS_FAILED;
            }

            return $status;
        }
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

    /**
     * The 2Checkout notification that was sent.
     *
     * @return string
     */
    public function notificationType()
    {
        return $this->data['message_type'];
    }
}
