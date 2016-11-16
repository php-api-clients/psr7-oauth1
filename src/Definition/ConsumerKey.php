<?php

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

final class ConsumerKey
{
    /**
     * @var string
     */
    private $consumerKey;

    /**
     * @param string $consumerKey
     */
    public function __construct($consumerKey)
    {
        $this->consumerKey = $consumerKey;
    }

    /**
     * @return string
     */
    public function getConsumerKey()
    {
        return (string) $this->consumerKey;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->consumerKey;
    }
}
