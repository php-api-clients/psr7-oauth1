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
        self::assertSame($token, $requestToken->getRequestToken()); /** @phpstan-ignore-line */
        self::assertSame($token, $requestToken->getToken()); /** @phpstan-ignore-line */
        self::assertSame($token, $requestToken->requestToken);
        self::assertSame($token, (string) $requestToken);
    }
}
