# Client-side PSR-7 Oauth1 request signer

[![Build Status](https://travis-ci.org/php-api-clients/psr7-oauth1.svg?branch=master)](https://travis-ci.org/php-api-clients/psr7-oauth1)
[![Latest Stable Version](https://poser.pugx.org/api-clients/psr7-oauth1/v/stable.png)](https://packagist.org/packages/api-clients/psr7-oauth1)
[![Total Downloads](https://poser.pugx.org/api-clients/psr7-oauth1/downloads.png)](https://packagist.org/packages/api-clients/psr7-oauth1/stats)
[![Code Coverage](https://scrutinizer-ci.com/g/php-api-clients/psr7-oauth1/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/php-api-clients/psr7-oauth1/?branch=master)
[![License](https://poser.pugx.org/api-clients/psr7-oauth1/license.png)](https://packagist.org/packages/api-clients/psr7-oauth1)
[![PHP 7 ready](http://php7ready.timesplinter.ch/php-api-clients/psr7-oauth1/badge.svg)](https://appveyor-ci.org/php-api-clients/psr7-oauth1)

# Installation

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `^`.

```bash
composer require api-clients/psr7-oauth1 
```

# Example

```php
<?php

use ApiClients\Tools\Psr7\Oauth1\Definition;
use ApiClients\Tools\Psr7\Oauth1\RequestSigning\RequestSigner;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSha1Signature;

$consumerSecret = new Definition\ConsumerSecret('consumer_secret');

$requestSigner = new RequestSigner(
    new Definition\ConsumerKey('consumer_key'),
    $consumerSecret,
    new HmacSha1Signature( // Optional, but allows for other than HMAC SHA1 signatures
        $consumerSecret  
    )
);

// Pass it a PSR-7 request and it returns a signed PSR7 request you can use in any PSR7 capable HTTP client.
$request = $requestSigner->withAccessToken(
    new Definition\AccessToken('token_key'),
    new Definition\TokenSecret('token_secret')
)->sign($request);
```

# Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

# License

The MIT License (MIT)

Copyright (c) 2016 Cees-Jan Kiewiet & Beau Simensen

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
