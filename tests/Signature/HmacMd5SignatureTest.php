<?php declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Signature;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacMd5Signature;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class HmacMd5SignatureTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethod()
    {
        $this->assertSame('HMAC-MD5', (new HmacMd5Signature(new ConsumerSecret('secret')))->getMethod());
    }

    public function provideSign(): \Generator
    {
        yield [
            new Uri('https://example.com/'),
            'QtfAAcCdkSRT7ZcsOf0ZMg==',
            'tgO8fZPz5fYTvT2fooRbVw==',
        ];

        yield [
            new Uri('https://example.com/thea.pot',[], 'THEAPOT'),
            '+ABQ6tWjft6x4qEWj2242A==',
            '/z1LDvLoyrM2/2UNr1vMfg==',
        ];

        yield [
            new Uri('https://example.com/?foo=bar', ['foo' => 'bar',]),
            'a1zvAGr9rNs+zbSnA4eAqQ==',
            'yVkadb1I3VWMaCpqp5ucYw==',
        ];

        yield [
            new Uri('https://example.com/',['foo' => 'bar',], 'HEAD'),
            'QtfAAcCdkSRT7ZcsOf0ZMg==',
            'tgO8fZPz5fYTvT2fooRbVw==',
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
        $signature = new HmacMd5Signature($secret);
        $tokenSecret = new TokenSecret('tokenSecret');
        $this->assertSame($signedSignature, $signature->sign($uri));
        $signature = $signature->withTokenSecret($tokenSecret);
        $this->assertSame($signedTokenSecretSignature, $signature->sign($uri));
        $signature = $signature->withoutTokenSecret();
        $this->assertSame($signedSignature, $signature->sign($uri));
    }
}
