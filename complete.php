<?php

require __DIR__ . '/vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('TwoCheckoutPlus');
$gateway->setAccountNumber('901290261');
$gateway->setSecretWord('MzBjODg5YTUtNzcwMS00N2NlLWFkODMtNzQ2YzllZWRjMzBj');
$gateway->setTestMode(true);

$response = $gateway->completePurchase()->send();

if ($response->isSuccessful()) {
    // payment was successful: update database
    print_r($response);
} elseif ($response->isRedirect()) {
    // redirect to offsite payment gateway
    $response->redirect();
} else {
    // payment failed: display message to customer
    echo $response->getMessage();
}