<?php declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Definition;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;

class ConsumerSecretTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessToken()
    {
        $key = 'key';
        $consumerSecret = new ConsumerSecret($key);
        $this->assertSame($key, $consumerSecret->getConsumerSecret());
        $this->assertSame($key, (string)$consumerSecret);
    }
}
