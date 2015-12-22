<?php

require __DIR__ . '/vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('TwoCheckoutPlus_Token');
$gateway->setAccountNumber('901290261');
$gateway->setSecretWord('MzBjODg5YTUtNzcwMS00N2NlLWFkODMtNzQ2YzllZWRjMzBj');
$gateway->setTestMode(true);
$gateway->setPrivateKey('4F876A36-D506-4E1F-8EE9-DA2358500F9C');

$formData = array(
    'firstName' => 'Example',
    'lastName' => 'User',
    'email' => 'me@w3guy.com',
    'number' => '4111111111111111',
    'expiryMonth' => rand(1, 12),
    'expiryYear' => gmdate('Y') + rand(1, 5),
    'cvv' => rand(100, 999),
    'billingAddress1' => '123 Billing St',
    'billingAddress2' => 'Billsville',
    'billingCity' => 'Billstown',
    'billingPostcode' => '12345',
    'billingState' => 'CA',
    'billingCountry' => 'US',
    'billingPhone' => '(555) 123-4567',
    'shippingAddress1' => '123 Shipping St',
    'shippingAddress2' => 'Shipsville',
    'shippingCity' => 'Shipstown',
    'shippingPostcode' => '54321',
    'shippingState' => 'NY',
    'shippingCountry' => 'US',
    'shippingPhone' => '(555) 987-6543',
);

$response = $gateway->purchase(
    array('card' => $formData, 'token' => 'Y2RkZDdjN2EtNjFmZS00ZGYzLWI4NmEtNGZhMjI3NmExMzQ0', 'transactionId' => '123456', 'currency' => 'USD', 'amount' => '20.5')
)->send();


var_dump($response->isSuccessful());
if ($response->isSuccessful()) {
    // payment was successful: update database
    var_dump($response->getTransactionReference());
} elseif ($response->isRedirect()) {
    // redirect to offsite payment gateway
    $response->redirect();
} else {
    // payment failed: display message to customer
    echo $response->getMessage();
}