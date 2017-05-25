# omnipay-verifone-web-service

**Verifone Web Service driver for the Omnipay PHP payment processing library**

Omnipay implementation of the Verifone (Commidea) Web Service payment gateway.

[![Build Status](https://travis-ci.org/digitickets/omnipay-verifone-web-service.png?branch=master)](https://travis-ci.org/digitickets/omnipay-verifone-web-service)
[![Latest Stable Version](https://poser.pugx.org/digitickets/omnipay-verifone-web-service/version.png)](https://packagist.org/packages/omnipay/verifone)
[![Total Downloads](https://poser.pugx.org/digitickets/omnipay-verifone-web-service/d/total.png)](https://packagist.org/packages/digitickets/omnipay-verifone-web-service)

This driver supports the remote Verifone Payment Gateway (Web Service). Payment information is sent and received via XML messages.

## Installation

**Important: Driver requires [PHP's Intl extension](http://php.net/manual/en/book.intl.php) to be installed.**

The Verifone Omnipay driver is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "digitickets/omnipay-verifone-web-service": "~1.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## What's Included

This driver currently only supports Session-Based transactions, except for refunds, which are non-session-based and have been implemented.

If you register a token, by default repeat payments will be available on any payments, although actually making repeat payments is not yet implemented.

## What's Not Included

This driver currently does not support Non-Session-Based transactions (except refunds, as above).

It does not currently support PAYERAUTH.

## Basic Usage

This driver supports the following process to handle a transaction:

Generate Session Request -> Generate Session Response\
-> \<card form submission to Verifone>\
-> Get Card Details Request -> Get Card Details Response\
-> Token Registration Request -> Token Registration Response [optional step]\
-> Purchase Request -> Purchase Response\
Then one of:\
-> Confirm Request -> Confirm Response\
or\
-> Reject Request -> Reject Response

It also supports making a refund:
Transaction (Refund) Request (non-session-based) -> Refund Response
Then one of:\
-> Confirm Request -> Confirm Response\
or\
-> Reject Request -> Reject Response

For general Omnipay usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay)
repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you believe you have found a bug in this driver, please report it using the [GitHub issue tracker](https://github.com/digitickets/omnipay-verifone-web-service/issues),
or better yet, fork the library and submit a pull request.
