<?php
namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Tests\TestCase;

class NotificationResponseTest extends TestCase
{
    public function testResponseFail()
    {
        $data = json_decode($this->getMockHttpResponse('FraudChangeNotificationFail.txt')->getBody()->getContents(), true);
        $data['accountNumber'] = '901290261';
        $data['secretWord'] = 'MzBjODg5YTUtNzcwMS00N2NlLWFkODMtNzQ2YzllZWRjMzBj';
        $response     = new NotificationResponse($this->getMockRequest(), $data);

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('4742525399', $response->getTransactionReference());
        $this->assertSame('1234567', $response->getTransactionId());
        $this->assertSame('FRAUD_STATUS_CHANGED', $response->getNotificationType());
        $this->assertTrue($response->getTransactionStatus());
        $this->assertSame($data, $response->getMessage());
    }
    public function testResponsePass()
    {
        $data = json_decode($this->getMockHttpResponse('FraudChangeNotificationPass.txt')->getBody()->getContents(), true);
        $data['accountNumber'] = '901290261';
        $data['secretWord'] = 'MzBjODg5YTUtNzcwMS00N2NlLWFkODMtNzQ2YzllZWRjMzBj';
        $response     = new NotificationResponse($this->getMockRequest(), $data);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('9093727242912', $response->getTransactionReference());
        $this->assertSame('3737', $response->getTransactionId());
        $this->assertSame('FRAUD_STATUS_CHANGED', $response->getNotificationType());
        $this->assertTrue($response->getTransactionStatus());
        $this->assertSame($data, $response->getMessage());
    }

    public function testForResponseOtherThanFraudReview() {
        $data = json_decode($this->getMockHttpResponse('FraudChangeNotificationPass.txt')->getBody()->getContents(), true);
        $data['accountNumber'] = '901290261';
        $data['secretWord'] = 'MzBjODg5YTUtNzcwMS00N2NlLWFkODMtNzQ2YzllZWRjMzBj';
        $data['message_type'] = 'INVOICE_STATUS_CHANGED';
        $response     = new NotificationResponse($this->getMockRequest(), $data);

        $this->assertTrue($response->getTransactionStatus());
    }
}
