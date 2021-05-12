<?php

declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Signature;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSha384Signature;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSignature;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

final class HmacSha384SignatureTest extends AbstractHmacSignatureTest
{
    public function testGetMethod(): void
    {
        self::assertSame('HMAC-SHA384', (new HmacSha384Signature(new ConsumerSecret('secret')))->getMethod());
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
            'JgaK+ORQ+mkdItwZUJgNI15mgIYHgcqEUIbp6qDbEhYrwwsrOrNxK+cgMMmY0/A7',
            '0Eib7qzwodDV6L4UYTOWS9G3UYPOvZCByUn02wrMMV0vNbNLGGFnA8IxnW6v1ZYN',
        ];

        yield [
            new Uri('https://example.com/thea.pot'),
            [],
            'THEAPOT',
            '4oJ9u7upxsArNUv/5C9dZv/eJeZdv8OSjPJa8B4Oc8Klc9fXacRNBBOK3hm0sIc0',
            'N95UKNiyD1Usy0yZD37bjJXInNoDry7A29IltBhINrL2CxBdEpE/m1tvSJSyU+Bn',
        ];

        yield [
            new Uri('https://example.com/?foo=bar'),
            ['bar' => 'beer'],
            'POST',
            'MXOJsgv11V0L8gsizK4kaR0pfZywXmcXzkwF/zma7do6fNUjUMhJgv4ZDRzFEACe',
            '+lOwMyE32LVHAnnIUrrGlScMqw07+Ab5cJjfluSvhXpI8CXqqS/zxvEjSFNaYSOu',
        ];

        yield [
            new Uri('https://example.com/'),
            ['foo' => 'bar'],
            'HEAD',
            'YVnY5nX+FQKUWVJySsxX8uLqtLAtnGflkny7BB0txjQQ4B//i461KQY9D3MLoyOE',
            'CGSZQdDMhlNgdY/p5Gnfkd4oDDT4dM1X1e9M50SvpPz5ABEzGWAZOXKsIwHFrCJ0',
        ];
    }

    public function createSignature(ConsumerSecret $secret): HmacSignature
    {
        return new HmacSha384Signature($secret);
    }
}
