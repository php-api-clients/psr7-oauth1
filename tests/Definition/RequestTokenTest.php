<?php

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Definition;

use ApiClients\Tools\Psr7\Oauth1\Definition\RequestToken;

class RequestTokenTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessToken()
    {
        $token = 'token';
        $requestToken = new RequestToken($token);
        $this->assertSame($token, $requestToken->getRequestToken());
        $this->assertSame($token, $requestToken->getToken());
        $this->assertSame($token, (string)$requestToken);
    }
}
