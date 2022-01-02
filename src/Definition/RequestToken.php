<?php

declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

final class RequestToken
{
    public function __construct(public readonly string $requestToken)
    {
    }

    /**
     * @deprecated Use requestToken property
     */
    public function getRequestToken(): string
    {
        return $this->requestToken;
    }

    /**
     * @deprecated Use requestToken property
     */
    public function getToken(): string
    {
        return $this->requestToken;
    }

    public function __toString(): string
    {
        return $this->requestToken;
    }
}
