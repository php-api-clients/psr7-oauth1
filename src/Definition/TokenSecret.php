<?php declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

final class TokenSecret
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
    public function getTokenSecret(): string
    {
        return (string) $this->tokenSecret;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->tokenSecret;
    }
}
