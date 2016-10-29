<?php

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

    public function provideSign()
    {
        return [
            [
                new Uri('https://example.com/'),
                'T7pWk5I7re3JTz5FS3LK8rVbQ0U=',
                'T7pWk5I7re3JTz5FS3LK8rVbQ0U=',
            ],
            [
                new Uri('https://example.com/thea.pot',[], 'THEAPOT'),
                'XyTxyDmU2s3iBMBpSX4DbZ47Ltg=',
                'XyTxyDmU2s3iBMBpSX4DbZ47Ltg=',
            ],
            [
                new Uri('https://example.com/?foo=bar', ['foo' => 'bar',]),
                'OXZBqYIhLdj7CT6bYudGqc8OzlU=',
                'OXZBqYIhLdj7CT6bYudGqc8OzlU=',
            ],
            [
                new Uri('https://example.com/',['foo' => 'bar',], 'HEAD'),
                'T7pWk5I7re3JTz5FS3LK8rVbQ0U=',
                'T7pWk5I7re3JTz5FS3LK8rVbQ0U=',
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
        $signature = new HmacSha1Signature($secret);
        $tokenSecret = new TokenSecret('tokenSecret');
        $this->assertSame($signedSignature, $signature->sign($uri));
        $signature->withTokenSecret($tokenSecret);
        $this->assertSame($signedTokenSecretSignature, $signature->sign($uri));
    }
}
