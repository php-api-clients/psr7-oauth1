<?php

declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Definition;

use ApiClients\Tools\Psr7\Oauth1\Definition\RequestToken;
use PHPUnit\Framework\TestCase;

final class RequestTokenTest extends TestCase
{
    public function testAccessToken(): void
    {
        $token        = 'token';
        $requestToken = new RequestToken($token);
        self::assertSame($token, $requestToken->getRequestToken());
        self::assertSame($token, $requestToken->getToken());
        self::assertSame($token, (string) $requestToken);
    }
}
