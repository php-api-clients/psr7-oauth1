<?php

declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\RequestSigning;

use ApiClients\Tools\Psr7\Oauth1\Definition\AccessToken;
use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerKey;
use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
use ApiClients\Tools\Psr7\Oauth1\Signature\HmacSha1Signature;
use ApiClients\Tools\Psr7\Oauth1\Signature\Signature;
use Psr\Http\Message\RequestInterface;
use Safe\DateTimeImmutable;

use function array_merge;
use function array_walk;
use function implode;
use function parse_str;
use function rawurlencode;
use function Safe\substr;
use function str_repeat;
use function str_shuffle;

final class RequestSigner
{
    private const NONCE_REPLICATION    = 10;
    private const START                = 0;
    private const DEFAULT_NONCE_LENGTH = 32;

    private ConsumerKey $consumerKey;

    private ?AccessToken $accessToken = null;

    private Signature $signature;

    /**
     * @phpstan-ignore-next-line
     */
    public function __construct(ConsumerKey $consumerKey, ConsumerSecret $consumerSecret, ?Signature $signature = null)
    {
        $this->consumerKey = $consumerKey;
        $this->signature   = $signature ?? new HmacSha1Signature($consumerSecret);
    }

    public function withAccessToken(AccessToken $accessToken, TokenSecret $tokenSecret): RequestSigner
    {
        $clone              = clone $this;
        $clone->accessToken = $accessToken;
        $clone->signature   = $clone->signature->withTokenSecret($tokenSecret);

        return $clone;
    }

    public function withoutAccessToken(): RequestSigner
    {
        $clone              = clone $this;
        $clone->accessToken = null;
        $clone->signature   = $clone->signature->withoutTokenSecret();

        return $clone;
    }

    public function sign(RequestInterface $request): RequestInterface
    {
        $parameters = [
            'oauth_consumer_key' => (string) $this->consumerKey,
            'oauth_nonce' => $this->generateNonce(),
            'oauth_signature_method' => $this->signature->getMethod(),
            'oauth_timestamp' => $this->generateTimestamp(),
            'oauth_version' => '1.0',
        ];

        if ($this->accessToken instanceof AccessToken) {
            $parameters['oauth_token'] = (string) $this->accessToken;
        }

        $parameters = $this->mergeSignatureParameter($request, $parameters);

        return $request->withHeader('Authorization', $this->generateAuthorizationheader($parameters));
    }

    /**
     * @param array<string, mixed> $additionalParameters
     */
    public function signToRequestAuthorization(
        RequestInterface $request,
        string $callbackUri,
        array $additionalParameters = []
    ): RequestInterface {
        $parameters = [
            'oauth_consumer_key' => (string) $this->consumerKey,
            'oauth_nonce' => $this->generateNonce(),
            'oauth_signature_method' => $this->signature->getMethod(),
            'oauth_timestamp' => $this->generateTimestamp(),
            'oauth_version' => '1.0',
            'oauth_callback' => $callbackUri,
        ];

        $parameters = array_merge($parameters, $additionalParameters);

        $parameters = $this->mergeSignatureParameter($request, $parameters);

        return $request->withHeader('Authorization', $this->generateAuthorizationheader($parameters));
    }

    /**
     * @param array<string, string> $parameters
     *
     * @return array<string, mixed>
     */
    private function mergeSignatureParameter(RequestInterface $request, array $parameters): array
    {
        $body = [];
        if (
            $request->getMethod() === 'POST' &&
            $request->getHeaderLine('Content-Type') === 'application/x-www-form-urlencoded'
        ) {
            parse_str((string) $request->getBody(), $body);
        }

        $signature = $this->signature->sign($request->getUri(), array_merge($body, $parameters), $request->getMethod());

        $parameters['oauth_signature'] = $signature;

        return $parameters;
    }

    private function generateTimestamp(): string
    {
        $dateTime = new DateTimeImmutable();

        return $dateTime->format('U');
    }

    private function generateNonce(int $length = self::DEFAULT_NONCE_LENGTH): string
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, self::NONCE_REPLICATION)), self::START, $length);
    }

    /**
     * @param array<string, mixed> $parameters
     */
    private function generateAuthorizationheader(array $parameters): string
    {
        array_walk($parameters, static function (string &$value, string $key): void {
            $value = rawurlencode($key) . '="' . rawurlencode($value) . '"';
        });

        return 'OAuth ' . implode(',', $parameters);
    }
}
