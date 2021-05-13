<?php

declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

final class ConsumerSecret
{
    private string $consumerSecret;

    public function __construct(string $consumerSecret)
    {
        $this->consumerSecret = $consumerSecret;
    }

    public function getConsumerSecret(): string
    {
        return $this->consumerSecret;
    }

    public function __toString(): string
    {
        return $this->consumerSecret;
    }
}
