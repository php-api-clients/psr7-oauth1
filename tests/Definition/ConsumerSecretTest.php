<?php declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Definition;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use PHPUnit\Framework\TestCase;

class ConsumerSecretTest extends TestCase
{
    public function testAccessToken()
    {
        $key = 'key';
        $consumerSecret = new ConsumerSecret($key);
        self::assertSame($key, $consumerSecret->getConsumerSecret());
        self::assertSame($key, (string)$consumerSecret);
    }
}
