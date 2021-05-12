<?php

declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Signature;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacMd5Signature;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSignature;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

final class HmacMd5SignatureTest extends AbstractHmacSignatureTest
{
    public function testGetMethod(): void
    {
        self::assertSame('HMAC-MD5', (new HmacMd5Signature(new ConsumerSecret('secret')))->getMethod());
    }

    /**
     * @return iterable<array<UriInterface|string|array>>
     */
    public function provideSign(): iterable
    {
        yield [
            new Uri('https://example.com/'),
            [],
            'POST',
            'QtfAAcCdkSRT7ZcsOf0ZMg==',
            'tgO8fZPz5fYTvT2fooRbVw==',
        ];

        yield [
            new Uri('https://example.com/thea.pot'),
            [],
            'THEAPOT',
            'n9V0csW37lXhdugt9bmtdA==',
            'ousrRZc2AyNfZd2WI5mWYg==',
        ];

        yield [
            new Uri('https://example.com/?foo=bar'),
            ['bar' => 'beer'],
            'POST',
            '66qH+87qtjCIjqHv97NQvg==',
            '72MIsmlLyU0OWdTksNnKPg==',
        ];

        yield [
            new Uri('https://example.com/'),
            ['foo' => 'bar'],
            'HEAD',
            'qlILpbappj4l7gdTL+3ySw==',
            'GWErzIhDA9AAas+shS6C3Q==',
        ];
    }

    public function createSignature(ConsumerSecret $secret): HmacSignature
    {
        return new HmacMd5Signature($secret);
    }
}
