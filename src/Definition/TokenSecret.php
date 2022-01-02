<?php

declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

final class TokenSecret
{
    public function __construct(public readonly string $tokenSecret)
    {
    }

    /**
     * @deprecated Use tokenSecret property
     */
    public function getTokenSecret(): string
    {
        return $this->tokenSecret;
    }

    public function __toString(): string
    {
        return $this->tokenSecret;
    }
}
