<?php

declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Definition;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use PHPUnit\Framework\TestCase;

final class ConsumerSecretTest extends TestCase
{
    public function testAccessToken(): void
    {
        $key            = 'key';
        $consumerSecret = new ConsumerSecret($key);
        self::assertSame($key, $consumerSecret->getConsumerSecret()); /** @phpstan-ignore-line */
        self::assertSame($key, $consumerSecret->consumerSecret);
        self::assertSame($key, (string) $consumerSecret);
    }
}
