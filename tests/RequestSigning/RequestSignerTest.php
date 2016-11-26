<?php declare(strict_types=1);

namespace ApiClients\Tests\Tools\Psr7\Oauth1\RequestSigning;

use ApiClients\Tools\Psr7\Oauth1\Definition\AccessToken;
use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerKey;
use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
use ApiClients\Tools\Psr7\Oauth1\RequestSigning\RequestSigner;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSha1Signature;
use GuzzleHttp\Psr7\Request;

class RequestSignerTest extends \PHPUnit_Framework_TestCase
{
    public function testImmutability()
    {
        $requestSigner = new RequestSigner(
            new ConsumerKey('consumer_key'),
            new ConsumerSecret('consumer_secret')
        );
        $requestSignerWithAccessToken = $requestSigner->withAccessToken(
            new AccessToken('access_token'),
            new TokenSecret('token_secret')
        );
        $this->assertNotSame($requestSigner, $requestSignerWithAccessToken);
        $requestSignerWithAccessTokenWithoutAccessToken = $requestSignerWithAccessToken->withoutAccessToken();
        $this->assertNotSame($requestSigner, $requestSignerWithAccessTokenWithoutAccessToken);
        $this->assertNotSame($requestSignerWithAccessToken, $requestSignerWithAccessTokenWithoutAccessToken);
        $this->assertEquals($requestSigner, $requestSignerWithAccessTokenWithoutAccessToken);
    }

    public function testSign()
    {
        $expectedHeaderParts = [
            'oauth_consumer_key' => false,
            'oauth_nonce' => false,
            'oauth_signature_method' => false,
            'oauth_timestamp' => false,
            'oauth_version' => false,
            'oauth_token' => false,
            'oauth_signature' => false,
        ];
        $captureValues = [
            'oauth_consumer_key' => '',
            'oauth_nonce' => '',
            'oauth_signature_method' => '',
            'oauth_timestamp' => '',
            'oauth_version' => '',
            'oauth_token' => '',
            'oauth_signature' => '',
        ];
        $request = new Request(
            'POST',
            'httpx://example.com/',
            [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'foo=bar'
        );
        $requestSigner = (new RequestSigner(
            new ConsumerKey('consumer_key'),
            new ConsumerSecret('consumer_secret')
        ))->withAccessToken(
            new AccessToken('access_token'),
            new TokenSecret('token_secret')
        );

        $signedRequest = $requestSigner->sign($request);

        $this->assertNotSame($request, $signedRequest);
        $this->assertTrue($signedRequest->hasHeader('Authorization'));
        $headerChunks = explode(' ', current($signedRequest->getHeader('Authorization')));
        $this->assertCount(2, $headerChunks);
        $this->assertSame('OAuth', $headerChunks[0]);

        $headerChunks = explode(',', $headerChunks[1]);
        $this->assertCount(count($expectedHeaderParts), $headerChunks);
        foreach ($headerChunks as $headerChunk) {
            list($key, $value) = explode('=', $headerChunk);
            $this->assertTrue(isset($expectedHeaderParts[$key]));
            if (isset($captureValues[$key])) {
                $captureValues[$key] = rawurldecode(str_replace('"', '', $value));
            }
            $expectedHeaderParts[$key] = true;
        }

        foreach ($expectedHeaderParts as $expectedHeaderPart) {
            $this->assertInternalType('bool', $expectedHeaderPart);
            $this->assertTrue($expectedHeaderPart);
        }

        $signature = $captureValues['oauth_signature'];
        unset($captureValues['oauth_signature']);

        $this->assertSame(
            (new HmacSha1Signature(
                new ConsumerSecret('consumer_secret')
            ))->withTokenSecret(
                new TokenSecret('token_secret')
            )->sign(
                $request->getUri(),
                array_merge(['foo' => 'bar'], $captureValues),
                'POST'
            ),
            $signature
        );
    }

    public function testSignToRequestAuthorization()
    {
        $callbackUri = 'https://example.com/callback';
        $expectedHeaderParts = [
            'oauth_consumer_key' => false,
            'oauth_nonce' => false,
            'oauth_signature_method' => false,
            'oauth_timestamp' => false,
            'oauth_version' => false,
            'oauth_callback' => false,
            'oauth_signature' => false,
        ];
        $captureValues = [
            'oauth_consumer_key' => '',
            'oauth_nonce' => '',
            'oauth_signature_method' => '',
            'oauth_timestamp' => '',
            'oauth_version' => '',
            'oauth_callback' => '',
            'oauth_signature' => '',
        ];
        $request = new Request(
            'POST',
            'httpx://example.com/',
            [],
            'foo=bar'
        );
        $requestSigner = new RequestSigner(
            new ConsumerKey('consumer_key'),
            new ConsumerSecret('consumer_secret')
        );

        $signedRequest = $requestSigner->signToRequestAuthorization($request, $callbackUri);

        $this->assertNotSame($request, $signedRequest);
        $this->assertTrue($signedRequest->hasHeader('Authorization'));
        $headerChunks = explode(' ', current($signedRequest->getHeader('Authorization')));
        $this->assertCount(2, $headerChunks);
        $this->assertSame('OAuth', $headerChunks[0]);

        $headerChunks = explode(',', $headerChunks[1]);
        $this->assertCount(count($expectedHeaderParts), $headerChunks);
        foreach ($headerChunks as $headerChunk) {
            list($key, $value) = explode('=', $headerChunk);
            $this->assertTrue(isset($expectedHeaderParts[$key]));
            if (isset($captureValues[$key])) {
                $captureValues[$key] = rawurldecode(str_replace('"', '', $value));
            }
            $expectedHeaderParts[$key] = true;
        }

        foreach ($expectedHeaderParts as $expectedHeaderPart) {
            $this->assertInternalType('bool', $expectedHeaderPart);
            $this->assertTrue($expectedHeaderPart);
        }

        $signature = $captureValues['oauth_signature'];
        unset($captureValues['oauth_signature']);

        $this->assertSame(
            (new HmacSha1Signature(
                new ConsumerSecret('consumer_secret')
            ))->sign(
                $request->getUri(),
                $captureValues,
                'POST'
            ),
            $signature
        );
    }
}
