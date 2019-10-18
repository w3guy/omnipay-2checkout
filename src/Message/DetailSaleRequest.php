<?php

namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Common\Http\Exception\NetworkException;
use Omnipay\Common\Http\Exception\RequestException;

/**
 * Purchase Request.
 *
 * @method PurchaseResponse send()
 */
class DetailSaleRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://www.2checkout.com/api/sales/detail_sale';
    protected $testEndpoint = 'https://sandbox.2checkout.com/api/sales/detail_sale';

    /**
     * Get appropriate 2checkout endpoints.
     *
     * @return string
     */
    public function getEndPoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * HTTP request headers.
     *
     * @return array
     */
    public function getRequestHeaders()
    {
        return [
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($this->getAdminUsername() . ':' . $this->getAdminPassword())
        ];
    }

    public function getData()
    {
        $this->validate('adminUsername', 'adminPassword');

        $data = [];
        $data['admin_username'] = $this->getAdminUsername();
        $data['admin_password'] = $this->getAdminPassword();

        $data['sale_id'] = $this->getSaleId();
        $data['invoice_id'] = $this->getInvoiceId();

        // needed to determine which API endpoint to use in OffsiteResponse
        if ($this->getTestMode()) {
            $data['sandbox'] = true;
        }

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        // remove unwanted data
        unset($data['sandbox']);

        return $data;
    }


    /**
     * @param mixed $data
     *
     * @return DetailSaleResponse
     */
    public function sendData($data)
    {
        $payload = $data;
        unset($payload['admin_username'], $payload['admin_password']);

        $query = '';
        if (!empty($payload['invoice_id'])) {
            $query = '?invoice_id=' . $payload['invoice_id'];
        }

        if (!empty($payload['sale_id'])) {
            $query = '?sale_id=' . $payload['sale_id'];
        }

        try {
            $response = $this->httpClient->request(
                'GET',
                $this->getEndpoint() . $query,
                $this->getRequestHeaders()
            );

            $json = json_decode($response->getBody()->getContents(), true);

            return new DetailSaleResponse($this, $json ?? []);
        } catch (RequestException|NetworkException $e) {
            return new DetailSaleResponse($this, ['error' => $e->getMessage()]);
        }
    }
}
