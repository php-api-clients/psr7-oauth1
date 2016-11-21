<?php

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Signature;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSha512Signature;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class HmacSha512SignatureTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethod()
    {
        $this->assertSame('HMAC-SHA512', (new HmacSha512Signature(new ConsumerSecret('secret')))->getMethod());
    }

    public function provideSign(): \Generator
    {
        yield [
            new Uri('https://example.com/'),
            'kWHPexc3goH9/jVh2MTYuAqMg6FLTKwZX63C9WmhuoCEoz1Ye5+kew3uSEg/JuQOWxbtN4jm05eSRuvIWmF0ZA==',
            'laMFvK2JMbORQp79wtajx0ESMG+U6DFlE0LBOacmsXK80dfTscLljseRi4pHeEUn1V+fDTNUIzTYjCK5DgQmRQ==',
        ];

        yield [
            new Uri('https://example.com/thea.pot',[], 'THEAPOT'),
            '/I2kMebX4xOddQTfJevI6wzFvltybVUTsHlL7h5LcsgySv2Me1+6XC35e79sKFWpw5WTYaOCM7D2MNInA5NKUw==',
            'kG+XGV4utRgXWt3tbJ5361sWHn86plmm1FcLYfjjRL0l1Ogv0D5lMOMWBrCt1pRGhO05he+DPUqZffyBh4M5GA==',
        ];

        yield [
            new Uri('https://example.com/?foo=bar', ['foo' => 'bar',]),
            'buNZpqvSzvJI1G1NLVGuiJnm/ZmZ59yfjGhUCXp8E8J98oEQHTMNua3Kawv41ejoj+KPgqw9JMZ/8HKeO7zvgg==',
            'xAllQX+xlZ6bzmthcEDZ9pyC5nyARMPaTuCe34YC9XeFIvAN+QRM1MattDvssurZN8UMPYHeyvbge1rPxygL8A==',
        ];

        yield [
            new Uri('https://example.com/',['foo' => 'bar',], 'HEAD'),
            'kWHPexc3goH9/jVh2MTYuAqMg6FLTKwZX63C9WmhuoCEoz1Ye5+kew3uSEg/JuQOWxbtN4jm05eSRuvIWmF0ZA==',
            'laMFvK2JMbORQp79wtajx0ESMG+U6DFlE0LBOacmsXK80dfTscLljseRi4pHeEUn1V+fDTNUIzTYjCK5DgQmRQ==',
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
        $signature = new HmacSha512Signature($secret);
        $tokenSecret = new TokenSecret('tokenSecret');
        $this->assertSame($signedSignature, $signature->sign($uri));
        $signature = $signature->withTokenSecret($tokenSecret);
        $this->assertSame($signedTokenSecretSignature, $signature->sign($uri));
        $signature = $signature->withoutTokenSecret();
        $this->assertSame($signedSignature, $signature->sign($uri));
    }
}
