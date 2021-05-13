<?php

declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Definition;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerKey;
use PHPUnit\Framework\TestCase;

final class ConsumerKeyTest extends TestCase
{
    public function testAccessToken(): void
    {
        $key         = 'key';
        $consumerKey = new ConsumerKey($key);
        self::assertSame($key, $consumerKey->getConsumerKey());
        self::assertSame($key, (string) $consumerKey);
    }
}
