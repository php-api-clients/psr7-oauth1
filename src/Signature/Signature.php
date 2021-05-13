<?php

declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Signature;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
use Psr\Http\Message\UriInterface;

use function rawurlencode;

abstract class Signature
{
    private ConsumerSecret $consumerSecret;

    private ?TokenSecret $tokenSecret = null;

    final public function __construct(ConsumerSecret $consumerSecret)
    {
        $this->consumerSecret = $consumerSecret;
    }

    final public function withTokenSecret(TokenSecret $tokenSecret): Signature
    {
        $clone              = clone $this;
        $clone->tokenSecret = $tokenSecret;

        return $clone;
    }

    final public function withoutTokenSecret(): Signature
    {
        $clone              = clone $this;
        $clone->tokenSecret = null;

        return $clone;
    }

    final protected function getKey(): string
    {
        $key = rawurlencode((string) $this->consumerSecret) . '&';

        if ($this->tokenSecret instanceof TokenSecret) {
            $key .= rawurlencode((string) $this->tokenSecret);
        }

        return $key;
    }

    abstract public function getMethod(): string;

    /**
     * @param array<string, string> $parameters
     */
    abstract public function sign(UriInterface $uri, array $parameters = [], string $method = 'POST'): string;
}
