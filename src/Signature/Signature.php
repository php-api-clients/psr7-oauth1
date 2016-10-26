<?php

namespace ApiClients\Tools\Psr7\Oauth1\Signature;

use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
use Psr\Http\Message\UriInterface;

abstract class Signature
{
    /**
     * @var ConsumerSecret
     */
    private $consumerSecret;

    /**
     * @var TokenSecret
     */
    private $tokenSecret;

    /**
     * @param ConsumerSecret $consumerSecret
     */
    public function __construct(ConsumerSecret $consumerSecret)
    {
        $this->consumerSecret = $consumerSecret;
    }

    /**
     * @param TokenSecret $tokenSecret
     * @return static
     */
    public function withTokenSecret(TokenSecret $tokenSecret)
    {
        $clone = clone $this;
        $clone->tokenSecret = $tokenSecret;

        return $clone;
    }

    /**
     * @return static
     */
    public function withoutTokenSecret()
    {
        $clone = clone $this;
        $clone->tokenSecret = null;

        return $clone;
    }

    protected function getKey()
    {
        $key = rawurlencode((string) $this->consumerSecret).'&';

        if ($this->tokenSecret) {
            $key .= rawurlencode((string) $this->tokenSecret);
        }

        return $key;
    }

    abstract public function getMethod();

    abstract public function sign(UriInterface $uri, array $parameters = [], $method = 'POST');
}
