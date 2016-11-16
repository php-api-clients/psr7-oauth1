<?php

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Signature;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSha384Signature;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class HmacSha384SignatureTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethod()
    {
        $this->assertSame('HMAC-SHA384', (new HmacSha384Signature(new ConsumerSecret('secret')))->getMethod());
    }

    public function provideSign()
    {
        return [
            [
                new Uri('https://example.com/'),
                'JgaK+ORQ+mkdItwZUJgNI15mgIYHgcqEUIbp6qDbEhYrwwsrOrNxK+cgMMmY0/A7',
                '0Eib7qzwodDV6L4UYTOWS9G3UYPOvZCByUn02wrMMV0vNbNLGGFnA8IxnW6v1ZYN',
            ],
            [
                new Uri('https://example.com/thea.pot',[], 'THEAPOT'),
                'Bm+fK6fVlejPvOcrQJcv+ZwsgQdh9W3Ok/ljmY39vy0MxymzH+I+Hntcxi90/Qfq',
                'mjT2JRgSTEdrMJi6/eJ6mZBh7C2bWT9HVqS1Gq6JpXJHNPze7gy7XdA4sgy3ORwE',
            ],
            [
                new Uri('https://example.com/?foo=bar', ['foo' => 'bar',]),
                '+88Vdw/72CKTOJpUM42FZLkQnBakun9M9lKVzk8a9T9TpmK9Sn6MP4hp7id/VJRj',
                'FKV3k1/PDOZTwMO6fE74NisTlixs1qlLt5IedDWVoIyk9tyNNAUIjwOt7w1GtnHH',
            ],
            [
                new Uri('https://example.com/',['foo' => 'bar',], 'HEAD'),
                'JgaK+ORQ+mkdItwZUJgNI15mgIYHgcqEUIbp6qDbEhYrwwsrOrNxK+cgMMmY0/A7',
                '0Eib7qzwodDV6L4UYTOWS9G3UYPOvZCByUn02wrMMV0vNbNLGGFnA8IxnW6v1ZYN',
            ],
        ];
    }

    /**
     * @param UriInterface $uri
     * @param $signedSignature
     * @dataProvider provideSign
     */
    public function testSign(UriInterface $uri, $signedSignature, $signedTokenSecretSignature)
    {
        $secret = new ConsumerSecret('consumerSecret');
        $signature = new HmacSha384Signature($secret);
        $tokenSecret = new TokenSecret('tokenSecret');
        $this->assertSame($signedSignature, $signature->sign($uri));
        $signature = $signature->withTokenSecret($tokenSecret);
        $this->assertSame($signedTokenSecretSignature, $signature->sign($uri));
        $signature = $signature->withoutTokenSecret();
        $this->assertSame($signedSignature, $signature->sign($uri));
    }
}
