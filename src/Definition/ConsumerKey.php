<?php

declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

final class ConsumerKey
{
    private string $consumerKey;

    public function __construct(string $consumerKey)
    {
        $this->consumerKey = $consumerKey;
    }

    public function getConsumerKey(): string
    {
        return $this->consumerKey;
    }

    public function __toString(): string
    {
        return $this->consumerKey;
    }
}
