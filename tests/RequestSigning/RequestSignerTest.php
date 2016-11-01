<?php

namespace ApiClients\Tests\Tools\Psr7\Oauth1\RequestSigning;

use ApiClients\Tools\Psr7\Oauth1\Definition\AccessToken;
use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerKey;
use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
use ApiClients\Tools\Psr7\Oauth1\RequestSigning\RequestSigner;

class RequestSignerTest extends \PHPUnit_Framework_TestCase
{
    public function testImmutability()
    {
        $requestSigner = new RequestSigner(
            new ConsumerKey('consumer_key'),
            new ConsumerSecret('consumer_secret')
        );
        $requestSignerWithAccessToken = $requestSigner->withAccessToken(
            new AccessToken('access_token'),
            new TokenSecret('token_secret')
        );
        $this->assertNotSame($requestSigner, $requestSignerWithAccessToken);
        $requestSignerWithAccessTokenWithoutAccessToken = $requestSignerWithAccessToken->withoutAccessToken();
        $this->assertNotSame($requestSigner, $requestSignerWithAccessTokenWithoutAccessToken);
        $this->assertNotSame($requestSignerWithAccessToken, $requestSignerWithAccessTokenWithoutAccessToken);
        $this->assertEquals($requestSigner, $requestSignerWithAccessTokenWithoutAccessToken);
    }
}
