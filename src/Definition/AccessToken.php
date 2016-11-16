<?php

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

final class AccessToken implements Token
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * @param string $accessToken
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return (string) $this->accessToken;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->accessToken;
    }
}
