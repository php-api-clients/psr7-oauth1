<?php declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Definition;

use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
use PHPUnit\Framework\TestCase;

class TokenSecretTest extends TestCase
{
    public function testAccessToken()
    {
        $token = 'tokenSecret';
        $tokenSecret = new TokenSecret($token);
        self::assertSame($token, $tokenSecret->getTokenSecret());
        self::assertSame($token, (string)$tokenSecret);
    }
}
