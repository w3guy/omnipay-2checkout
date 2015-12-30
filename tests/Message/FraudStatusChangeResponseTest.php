<?php
namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Tests\TestCase;

class FraudStatusChangeResponseTest extends TestCase
{
    public function testResponseFail()
    {
        $data = $this->getMockHttpResponse('FraudChangeNotification.txt')->json();
        $data['accountNumber'] = '901290261';
        $data['secretWord'] = 'MzBjODg5YTUtNzcwMS00N2NlLWFkODMtNzQ2YzllZWRjMzBj';
        $response     = new FraudStatusChangeResponse($this->getMockRequest(), $data);

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('4742525399', $response->getTransactionReference());
        $this->assertSame('FRAUD_STATUS_CHANGED', $response->notificationType());
        $this->assertSame(NotificationInterface::STATUS_FAILED, $response->getTransactionStatus());
        $this->assertSame($data, $response->getMessage());
    }
}