<?php

declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

final class ConsumerKey
{
    public function __construct(public readonly string $consumerKey)
    {
    }

    /**
     * @deprecated Use consumerKey property
     */
    public function getConsumerKey(): string
    {
        return $this->consumerKey;
    }

    public function __toString(): string
    {
        return $this->consumerKey;
    }
}
