<?php

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Definition;

use ApiClients\Tools\Psr7\Oauth1\Definition\AccessToken;

class AccessTokenTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessToken()
    {
        $token = 'token';
        $accessToken = new AccessToken($token);
        $this->assertSame($token, $accessToken->getAccessToken());
        $this->assertSame($token, $accessToken->getToken());
        $this->assertSame($token, (string)$accessToken);
    }
}
