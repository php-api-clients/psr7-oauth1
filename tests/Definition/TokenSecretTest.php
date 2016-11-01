<?php

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Definition;

use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;

class TokenSecretTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessToken()
    {
        $token = 'tokenSecret';
        $tokenSecret = new TokenSecret($token);
        $this->assertSame($token, $tokenSecret->getTokenSecret());
        $this->assertSame($token, (string)$tokenSecret);
    }
}
