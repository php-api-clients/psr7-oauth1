<?php

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Definition;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerKey;

class ConsumerKeyTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessToken()
    {
        $key = 'key';
        $consumerKey = new ConsumerKey($key);
        $this->assertSame($key, $consumerKey->getConsumerKey());
        $this->assertSame($key, (string)$consumerKey);
    }
}
