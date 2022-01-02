<?php

declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

final class ConsumerSecret
{
    public function __construct(public readonly string $consumerSecret)
    {
    }

    /**
     * @deprecated Use consumerSecret property
     */
    public function getConsumerSecret(): string
    {
        return $this->consumerSecret;
    }

    public function __toString(): string
    {
        return $this->consumerSecret;
    }
}
