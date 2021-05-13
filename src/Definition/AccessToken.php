<?php

declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

final class AccessToken
{
    private string $accessToken;

    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getToken(): string
    {
        return $this->accessToken;
    }

    public function __toString(): string
    {
        return $this->accessToken;
    }
}
