<?php

namespace ApiClients\Tests\Tools\Psr7\Oauth1\RequestSigning;

use ApiClients\Tools\Psr7\Oauth1\Definition\AccessToken;
use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerKey;
use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
use ApiClients\Tools\Psr7\Oauth1\RequestSigning\RequestSigner;
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
        $request = new Request(
            'POST',
            'httpx://example.com/',
            [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
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
            $expectedHeaderParts[$key] = true;
        }

        foreach ($expectedHeaderParts as $expectedHeaderPart) {
            $this->assertInternalType('bool', $expectedHeaderPart);
            $this->assertTrue($expectedHeaderPart);
        }
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
        $request = new Request(
            'POST',
            'httpx://example.com/',
            [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
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
            $expectedHeaderParts[$key] = true;
        }

        foreach ($expectedHeaderParts as $expectedHeaderPart) {
            $this->assertInternalType('bool', $expectedHeaderPart);
            $this->assertTrue($expectedHeaderPart);
        }
    }
}
