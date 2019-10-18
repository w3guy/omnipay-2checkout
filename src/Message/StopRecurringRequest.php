<?php

namespace Omnipay\TwoCheckoutPlus\Message;

use Guzzle\Http\Exception\BadResponseException;
use Omnipay\Common\Http\Exception\NetworkException;
use Omnipay\Common\Http\Exception\RequestException;

/**
 * Purchase Request.
 *
 * @method PurchaseResponse send()
 */
class StopRecurringRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://www.2checkout.com/api/sales/stop_lineitem_recurring';
    protected $testEndpoint = 'https://sandbox.2checkout.com/api/sales/stop_lineitem_recurring';

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
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($this->getAdminUsername() . ':' . $this->getAdminPassword()),
        ];
    }

    public function getData()
    {
        $this->validate('adminUsername', 'adminPassword', 'lineItemId');

        $data = array();
        $data['admin_username'] = $this->getAdminUsername();
        $data['admin_password'] = $this->getAdminPassword();

        $data['lineitem_id'] = $this->getLineItemId();

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
     * @return StopRecurringResponse
     */
    public function sendData($data)
    {
        $payload = $data;
        unset($payload['admin_username'], $payload['admin_password']);

        try {
            $response = $this->httpClient->request(
                'POST',
                $this->getEndpoint(),
                $this->getRequestHeaders(),
                json_encode($payload)
            );
            $json = json_decode($response->getBody()->getContents(), true);

            return new StopRecurringResponse($this, $json ?? []);
        } catch (RequestException|NetworkException $e) {
            return new StopRecurringResponse($this, ['error' => $e->getMessage()]);
        }
    }
}
