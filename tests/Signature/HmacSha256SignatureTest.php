<?php declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Signature;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSha256Signature;
use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;

class HmacSha256SignatureTest extends TestCase
{
    public function testGetMethod()
    {
        self::assertSame('HMAC-SHA256', (new HmacSha256Signature(new ConsumerSecret('secret')))->getMethod());
    }

    public function provideSign(): \Generator
    {
        yield [
            new Uri('https://example.com/'),
            'x0e2N4wRpr2UB+rX8mwnY01tp6fnXT5SE36kAvbdSYo=',
            'ovXZ33UaQylAO8L8Ad1f/TwLU1YBXEygau34O7sDSw0=',
        ];

        yield [
            new Uri('https://example.com/thea.pot',[], 'THEAPOT'),
            'u5nNam6Cn+fCko38qAgxWUYmRrPPTF5OFOC9wZ4LHRg=',
            '8IQ1uD3ZR+b8U0Fd++pGGzqNmKiF94z3psbsa+M0SxQ=',
        ];

        yield [
            new Uri('https://example.com/?foo=bar', ['foo' => 'bar',]),
            'SlDm7qfJO/mxl1Ewnewj46jjbuCEKYGNTeew2uMDwPM=',
            '5vVeCSAcL52LVGWWQ1pUFUe7cpVwkhreMQMck3PEw+E=',
        ];

        yield [
            new Uri('https://example.com/',['foo' => 'bar',], 'HEAD'),
            'x0e2N4wRpr2UB+rX8mwnY01tp6fnXT5SE36kAvbdSYo=',
            'ovXZ33UaQylAO8L8Ad1f/TwLU1YBXEygau34O7sDSw0=',
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
        $signature = new HmacSha256Signature($secret);
        $tokenSecret = new TokenSecret('tokenSecret');
        self::assertSame($signedSignature, $signature->sign($uri));
        $signature = $signature->withTokenSecret($tokenSecret);
        self::assertSame($signedTokenSecretSignature, $signature->sign($uri));
        $signature = $signature->withoutTokenSecret();
        self::assertSame($signedSignature, $signature->sign($uri));
    }
}
