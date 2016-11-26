<?php declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

final class RequestToken
{
    /**
     * @var string
     */
    private $requestToken;

    /**
     * @param string $requestToken
     */
    public function __construct($requestToken)
    {
        $this->requestToken = $requestToken;
    }

    /**
     * @return string
     */
    public function getRequestToken(): string
    {
        return $this->requestToken;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return (string) $this->requestToken;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->requestToken;
    }
}
