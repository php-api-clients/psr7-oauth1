<?php

declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

final class RequestToken
{
    private string $requestToken;

    public function __construct(string $requestToken)
    {
        $this->requestToken = $requestToken;
    }

    public function getRequestToken(): string
    {
        return $this->requestToken;
    }

    public function getToken(): string
    {
        return $this->requestToken;
    }

    public function __toString(): string
    {
        return $this->requestToken;
    }
}
