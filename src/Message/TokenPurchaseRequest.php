<?php

namespace Omnipay\TwoCheckoutPlus\Message;

use Guzzle\Http\Exception\BadResponseException;

/**
 * Purchase Request.
 *
 * @method PurchaseResponse send()
 */
class TokenPurchaseRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://www.2checkout.com/checkout/api/1/';
    protected $testEndpoint = 'https://sandbox.2checkout.com/checkout/api/1/';

    public function getEndpoint()
    {
        $endpoint = $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;

        return $endpoint.$this->getAccountNumber().'/rs/authService';
    }
    public function getRequestHeaders()
    {
        return array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        );
    }

    public function getData()
    {
        $this->validate('accountNumber', 'privateKey', 'token', 'amount', 'transactionId');

        $data = array();
        $data['sellerId'] = $this->getAccountNumber();
        $data['privateKey'] = $this->getPrivateKey();
        $data['merchantOrderId'] = $this->getTransactionId();
        $data['token'] = $this->getToken();
        $data['currency'] = $this->getCurrency();
        $data['total'] = $this->getAmount();

        if ($this->getCard()) {
            $data['billingAddr']['name'] = $this->getCard()->getName();
            $data['billingAddr']['addrLine1'] = $this->getCard()->getAddress1();
            $data['billingAddr']['addrLine2'] = $this->getCard()->getAddress2();
            $data['billingAddr']['city'] = $this->getCard()->getCity();
            $data['billingAddr']['state'] = $this->getCard()->getState();
            $data['billingAddr']['zipCode'] = $this->getCard()->getPostcode();
            $data['billingAddr']['email'] = $this->getCard()->getEmail();
            $data['billingAddr']['country'] = $this->getCard()->getCountry();
            $data['billingAddr']['phoneNumber'] = $this->getCard()->getPhone();
            // add this if PR (https://github.com/thephpleague/omnipay-common/pull/71) is merged
            //$data['billingAddr']['phoneExt'] = $this->getCard()->getPhoneExtension();
        }

        return $data;
    }

    public function sendData($data)
    {
        try {
            $response = $this->httpClient->post(
                $this->getEndpoint(),
                $this->getRequestHeaders(),
                json_encode($data)
            )->send();

            return new TokenPurchaseResponse($this, $response->json());
        } catch (BadResponseException $e) {
            $response = $e->getResponse();

            return new TokenPurchaseResponse($this, $response->json());
        }
    }
}
