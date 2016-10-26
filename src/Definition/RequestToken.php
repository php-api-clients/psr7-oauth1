<?php

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

class RequestToken implements Token
{
    /**
     * @var string
     */
    private $requestToken;

    /**
     * @param string $token
     */
    public function __construct($requestToken)
    {
        $this->requestToken = $requestToken;
    }

    /**
     * @return string
     */
    public function getRequestToken()
    {
        return $this->requestToken;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return (string) $this->requestToken;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->requestToken;
    }
}
