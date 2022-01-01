<?php

declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Signature;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSha1Signature;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSignature;
use GuzzleHttp\Psr7\Uri;

final class HmacSha1SignatureTest extends AbstractHmacSignatureTest
{
    public function testGetMethod(): void
    {
        self::assertSame('HMAC-SHA1', (new HmacSha1Signature(new ConsumerSecret('secret')))->getMethod());
    }

    /**
     * @return iterable<array<mixed>>
     */
    public function provideSign(): iterable
    {
        yield [
            new Uri('https://example.com/'),
            [],
            'POST',
            'T7pWk5I7re3JTz5FS3LK8rVbQ0U=',
            'uRcxk5ukl+O0nSa9PgMEoIvOQ+M=',
        ];

        yield [
            new Uri('https://example.com/thea.pot'),
            [],
            'THEAPOT',
            'L5pcHgA24a1/tIm9GXpw2eX2rfU=',
            '5qujgjzS3VIiHu/yy9nTyTffous=',
        ];

        yield [
            new Uri('https://example.com/?foo=bar'),
            ['bar' => 'beer'],
            'POST',
            '/M0RQX1ckariWsYpcYB37gj9sOk=',
            'jKwc7IOu0xLR93F1nmLk4rMqhZk=',
        ];

        yield [
            new Uri('https://example.com/'),
            ['foo' => 'bar'],
            'HEAD',
            'x7KGhj016R+lLu5l745FiA7WmAk=',
            'k4pYkc9Btj+8aV4fDQmUDZdnGbM=',
        ];
    }

    public function createSignature(ConsumerSecret $secret): HmacSignature
    {
        return new HmacSha1Signature($secret);
    }
}
