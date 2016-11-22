<?php declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Signature;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSha1Signature;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class HmacSha1SignatureTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethod()
    {
        $this->assertSame('HMAC-SHA1', (new HmacSha1Signature(new ConsumerSecret('secret')))->getMethod());
    }

    public function provideSign(): \Generator
    {
        yield [
            new Uri('https://example.com/'),
            'T7pWk5I7re3JTz5FS3LK8rVbQ0U=',
            'uRcxk5ukl+O0nSa9PgMEoIvOQ+M=',
        ];

        yield [
            new Uri('https://example.com/thea.pot',[], 'THEAPOT'),
            'XyTxyDmU2s3iBMBpSX4DbZ47Ltg=',
            'H6aCWT5WcUlqw4/qXVm4tMjE7P0=',
        ];

        yield [
            new Uri('https://example.com/?foo=bar', ['foo' => 'bar',]),
            'OXZBqYIhLdj7CT6bYudGqc8OzlU=',
            '3oA2qaA8dpQFdB8n0tyjrXLNvsg=',
        ];

        yield [
            new Uri('https://example.com/',['foo' => 'bar',], 'HEAD'),
            'T7pWk5I7re3JTz5FS3LK8rVbQ0U=',
            'uRcxk5ukl+O0nSa9PgMEoIvOQ+M=',
        ];
    }

    /**
     * @param UriInterface $uri
     * @param $signedSignature
     * @dataProvider provideSign
     */
    public function testSign(UriInterface $uri, string $signedSignature, string $signedTokenSecretSignature)
    {
        $secret = new ConsumerSecret('consumerSecret');
        $signature = new HmacSha1Signature($secret);
        $tokenSecret = new TokenSecret('tokenSecret');
        $this->assertSame($signedSignature, $signature->sign($uri));
        $signature = $signature->withTokenSecret($tokenSecret);
        $this->assertSame($signedTokenSecretSignature, $signature->sign($uri));
        $signature = $signature->withoutTokenSecret();
        $this->assertSame($signedSignature, $signature->sign($uri));
    }
}
