<?php

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

class TokenSecret
{
    /**
     * @var string
     */
    private $tokenSecret;

    /**
     * @param string $tokenSecret
     */
    public function __construct($tokenSecret)
    {
        $this->tokenSecret = $tokenSecret;
    }

    /**
     * @return string
     */
    public function getTokenSecret()
    {
        return (string) $this->tokenSecret;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->tokenSecret;
    }
}
