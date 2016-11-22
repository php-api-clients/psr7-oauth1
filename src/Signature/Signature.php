<?php declare(strict_types=1);

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
     * @return Signature
     */
    public function withTokenSecret(TokenSecret $tokenSecret): Signature
    {
        $clone = clone $this;
        $clone->tokenSecret = $tokenSecret;

        return $clone;
    }

    /**
     * @return Signature
     */
    public function withoutTokenSecret(): Signature
    {
        $clone = clone $this;
        $clone->tokenSecret = null;

        return $clone;
    }

    /**
     * @return string
     */
    protected function getKey(): string
    {
        $key = rawurlencode((string) $this->consumerSecret).'&';

        if ($this->tokenSecret) {
            $key .= rawurlencode((string) $this->tokenSecret);
        }

        return $key;
    }

    /**
     * @return string
     */
    abstract public function getMethod(): string;

    /**
     * @param UriInterface $uri
     * @param array $parameters
     * @param string $method
     * @return string
     */
    abstract public function sign(UriInterface $uri, array $parameters = [], string $method = 'POST'): string;
}
