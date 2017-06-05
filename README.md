# Omnipay: 2checkout

**2checkout gateway for the Omnipay PHP payment processing library**

[![Latest Version on Packagist](https://img.shields.io/packagist/v/collizo4sky/omnipay-2checkout.svg?style=flat-square)](https://packagist.org/packages/collizo4sky/omnipay-2checkout)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/collizo4sky/omnipay-2checkout/master.svg?style=flat-square)](https://travis-ci.org/collizo4sky/omnipay-2checkout)
[![Coverage Status](https://coveralls.io/repos/collizo4sky/omnipay-2checkout/badge.svg?branch=master&service=github)](https://coveralls.io/github/collizo4sky/omnipay-2checkout?branch=master)
[![Code Climate](https://codeclimate.com/github/collizo4sky/omnipay-2checkout/badges/gpa.svg)](https://codeclimate.com/github/collizo4sky/omnipay-2checkout)
[![Dependency Status](https://www.versioneye.com/user/projects/56790f2210799700300013b8/badge.svg?style=flat)](https://www.versioneye.com/user/projects/56790f2210799700300013b8)
[![Total Downloads](https://img.shields.io/packagist/dt/collizo4sky/omnipay-2checkout.svg?style=flat-square)](https://packagist.org/packages/collizo4sky/omnipay-2checkout)


[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements 2checkout support for Omnipay.

## Install

Via Composer

``` bash
$ composer require collizo4sky/omnipay-2checkout
```

## Usage

The following gateways are provided by this package:

 * TwoCheckoutPlus
 * TwoCheckoutPlus_Token
 
### TwoCheckoutPlus
``` php

use Omnipay\Omnipay;

$gateway = Omnipay::create('TwoCheckoutPlus');
$gateway->setAccountNumber($this->account_number);
$gateway->setSecretWord($this->secret_word);
$gateway->setTestMode($this->is_sandbox_test());
// activate test mode by passing demo parameter to checkout parameters.
$gateway->setDemoMode($this->is_test_mode());


try {
    $formData = array(
        'firstName' => $order->get_billing_first_name(),
        'lastName' => $order->get_billing_last_name(),
        'email' => $order->get_billing_email(),
        'address1' => $order->get_billing_address_1(),
        'address2' => $order->get_billing_address_2(),
        'city' => $order->get_billing_city(),
        'state' => $order->get_billing_state(),
        'postcode' => $order->get_billing_postcode(),
        'country' => $order->get_billing_country(),
    );

    $order_cart = $order->get_items();

    $cart = array();

    $i = 0;
    foreach ($order_cart as $order_item_id => $product) {
        $product_id = $product['product_id'];
        $cart[$i]['name'] = $product['name'];
        $cart[$i]['quantity'] = $product['qty'];
        $cart[$i]['type'] = 'product';
        $cart[$i]['price'] = round($product['line_subtotal'] / $product['qty'], 2);
        $cart[$i]['product_id'] = $product_id;

        $i++;
    }

    if (($shipping_total = $order->get_shipping_total()) > 0) {
        $cart[] = array(
            'name' => 'Shipping Fee',
            'quantity' => 1,
            'type' => 'shipping',
            'price' => round($shipping_total, 2),
        );
    }

    if (($discount_total = $order->get_total_discount()) > 0) {
        $cart[] = array(
            'name' => 'Discount',
            'quantity' => 1,
            'type' => 'coupon',
            'price' => round($discount_total, 2),
        );
    }

    if (($tax_total = $order->get_total_tax()) > 0) {
        $cart[] = array(
            'name' => 'Tax Fee',
            'type' => 'tax',
            'quantity' => 1,
            'price' => round($tax_total, 2),
        );
    }

    $gateway->setCart($cart);

    $response = $gateway->purchase(
        array(
            'card' => $formData,
            'transactionId' => $order->get_order_number(),
            'currency' => 'USD,
            // add a query parameter to the returnUrl to listen and complete payment
            'returnUrl' => $this->returnUrl,
        )
    )->send();


    if ($response->isRedirect()) {
        $response->getRedirectUrl();

    } else {
        $error = $response->getMessage();
    }
} catch (Exception $e) {
    $e->getMessage();
}
```

### TwoCheckoutPlus_Token

``` php
use Omnipay\Omnipay;

try {
    $gateway = Omnipay::create('TwoCheckoutPlus_Token');
    $gateway->setAccountNumber($this->account_number);
    $gateway->setTestMode($this->is_sandbox_test());
    $gateway->setPrivateKey($this->private_key);

    $formData = array(
        'firstName' => $order->get_billing_first_name(),
        'lastName' => $order->get_billing_last_name(),
        'email' => $order->get_billing_email(),
        'billingAddress1' => $order->get_billing_address_1(),
        'billingAddress2' => $order->get_billing_address_2(),
        'billingCity' => $order->get_billing_city(),
        'billingPostcode' => $order->get_billing_postcode(),
        'billingState' => $order->get_billing_state(),
        'billingCountry' => $order->get_billing_country(),
    );


    $purchase_request_data = array(
        'card' => $formData,
        'token' => sanitize_text_field($_POST['twocheckout_token']),
        'transactionId' => $order->get_order_number(),
        'currency' => 'USD',
        'amount' => $order->order_total,
    );

    $response = $gateway->purchase($purchase_request_data)->send();

    if ($response->isSuccessful()) {
        $transaction_ref = $response->getTransactionReference();
    } else {
        $error = $response->getMessage();
    }
} catch (Exception $e) {
    $e->getMessage();
}
```

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay) repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/collizo4sky/omnipay-2checkout/issues),
or better yet, fork the library and submit a pull request.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email me@w3guy.com instead of using the issue tracker.

## Credits

- [Agbonghama Collins](https://github.com/collizo4sky)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
