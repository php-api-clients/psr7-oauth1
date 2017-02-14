<?php declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Definition;

use ApiClients\Tools\Psr7\Oauth1\Definition\AccessToken;
use PHPUnit\Framework\TestCase;

class AccessTokenTest extends TestCase
{
    public function testAccessToken()
    {
        $token = 'token';
        $accessToken = new AccessToken($token);
        self::assertSame($token, $accessToken->getAccessToken());
        self::assertSame($token, $accessToken->getToken());
        self::assertSame($token, (string)$accessToken);
    }
}
