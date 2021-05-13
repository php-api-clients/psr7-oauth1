<?php

declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

final class TokenSecret
{
    private string $tokenSecret;

    public function __construct(string $tokenSecret)
    {
        $this->tokenSecret = $tokenSecret;
    }

    public function getTokenSecret(): string
    {
        return $this->tokenSecret;
    }

    public function __toString(): string
    {
        return $this->tokenSecret;
    }
}
