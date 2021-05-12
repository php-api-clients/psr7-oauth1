<?php

declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Signature;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSignature;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;

abstract class AbstractHmacSignatureTest extends TestCase
{
    /**
     * @return iterable<array<UriInterface|string|array>>
     */
    abstract public function provideSign(): iterable;

    abstract public function createSignature(ConsumerSecret $secret): HmacSignature;

    /**
     * @param array<string, string> $parameters
     *
     * @dataProvider provideSign
     */
    final public function testSign(UriInterface $uri, array $parameters, string $method, string $signedSignature, string $signedTokenSecretSignature): void
    {
        $secret      = new ConsumerSecret('consumerSecret');
        $signature   = $this->createSignature($secret);
        $tokenSecret = new TokenSecret('tokenSecret');
        self::assertSame($signedSignature, $signature->sign($uri, $parameters, $method));
        $oldSignature = $signature;
        $signature    = $signature->withTokenSecret($tokenSecret);
        self::assertNotSame($oldSignature, $signature);
        self::assertSame($signedTokenSecretSignature, $signature->sign($uri, $parameters, $method));
        $oldSignature = $signature;
        $signature    = $signature->withoutTokenSecret();
        self::assertNotSame($oldSignature, $signature);
        self::assertSame($signedSignature, $signature->sign($uri, $parameters, $method));
    }
}
