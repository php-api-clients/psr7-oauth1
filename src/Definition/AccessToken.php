<?php declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

final class AccessToken
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
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return (string) $this->accessToken;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->accessToken;
    }
}
