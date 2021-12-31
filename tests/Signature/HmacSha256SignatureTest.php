<?php

declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Signature;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSha256Signature;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSignature;
use GuzzleHttp\Psr7\Uri;

final class HmacSha256SignatureTest extends AbstractHmacSignatureTest
{
    public function testGetMethod(): void
    {
        self::assertSame('HMAC-SHA256', (new HmacSha256Signature(new ConsumerSecret('secret')))->getMethod());
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
            'x0e2N4wRpr2UB+rX8mwnY01tp6fnXT5SE36kAvbdSYo=',
            'ovXZ33UaQylAO8L8Ad1f/TwLU1YBXEygau34O7sDSw0=',
        ];

        yield [
            new Uri('https://example.com/thea.pot'),
            [],
            'THEAPOT',
            'nmPRvW2t1VOH8aBTX4DoGLWageh1/72OVuLFLVpDX6g=',
            '7F1Fq54hSTujiM8afiq9u3kZ03/LIxfgMrcc6uymYJc=',
        ];

        yield [
            new Uri('https://example.com/?foo=bar'),
            ['bar' => 'beer'],
            'POST',
            'JyojVPP4Pf/vW6G9OoztATqibuTeQTUhuiTISAR7PpQ=',
            'u6/LoNJUKPvj5TRg8/5YMbp+z2paY10fLlaUlV0ePME=',
        ];

        yield [
            new Uri('https://example.com/'),
            ['foo' => 'bar'],
            'HEAD',
            '3/qGxQYiHcoaPVGfuT2J8VaGthmO34KWNKQa4W2tLvQ=',
            'q6PmZbegey7QM5TQ/S0DI7UBSV4XbxvJ5iYnFbLrATc=',
        ];
    }

    public function createSignature(ConsumerSecret $secret): HmacSignature
    {
        return new HmacSha256Signature($secret);
    }
}
