<?php

declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

final class AccessToken
{
    public function __construct(public readonly string $accessToken)
    {
    }

    /**
     * @deprecated Use accessToken property
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @deprecated Use accessToken property
     */
    public function getToken(): string
    {
        return $this->accessToken;
    }

    public function __toString(): string
    {
        return $this->accessToken;
    }
}
