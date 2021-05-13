<?php

declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\Signature;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSha512Signature;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSignature;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

final class HmacSha512SignatureTest extends AbstractHmacSignatureTest
{
    public function testGetMethod(): void
    {
        self::assertSame('HMAC-SHA512', (new HmacSha512Signature(new ConsumerSecret('secret')))->getMethod());
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
            'kWHPexc3goH9/jVh2MTYuAqMg6FLTKwZX63C9WmhuoCEoz1Ye5+kew3uSEg/JuQOWxbtN4jm05eSRuvIWmF0ZA==',
            'laMFvK2JMbORQp79wtajx0ESMG+U6DFlE0LBOacmsXK80dfTscLljseRi4pHeEUn1V+fDTNUIzTYjCK5DgQmRQ==',
        ];

        yield [
            new Uri('https://example.com/thea.pot'),
            [],
            'THEAPOT',
            'fejN7Cg6/vIF+SS2e5jPFHH/bM0kW/GCuuth5fAViXeTC7lTOYAryxXk7YOsCPMmsNH9zZNTA1qGwnheRsPsxA==',
            'EM6bzGyURTc6cbLoP1WEIRkWtCEGnReiY5FzGDq99250p0YQ0ybbPak3qI0AQVbgEedka4jSOha72PqLtgVRlw==',
        ];

        yield [
            new Uri('https://example.com/?foo=bar'),
            ['bar' => 'beer'],
            'POST',
            'UeuspnAfh88y9TxMsmnieoaVHtjebXI5N93Z5CX5aRcSFV3Yvr2S7wQZ7b92UdVSH38dCAQa7QK+c7AhjWSsWQ==',
            'LsOrRFEe+wGZUmHZxnuhVdEzm+cKvOmElFnYFnsvpz8n4t4c2uh1jiAfhi/N8aozUMqw86cOeEYVdUcOkdBuaw==',
        ];

        yield [
            new Uri('https://example.com/'),
            ['foo' => 'bar'],
            'HEAD',
            'rw0TiZnsgTyZGafoSdbyZwXK06Chp7uQFBW9+kVwxrFaJKVLFq7+lNKGJOOo7pHXdVg4/vgHp55MYOF8qpn25w==',
            'ObJvUsu5NsP/RmB0kCkhiTHQZtIhLuHoKWBFUe+/h5MIMZCqil1IH65hZJmjLNjmkbzAQhpeOs1MAPg3b07wZg==',
        ];
    }

    public function createSignature(ConsumerSecret $secret): HmacSignature
    {
        return new HmacSha512Signature($secret);
    }
}
