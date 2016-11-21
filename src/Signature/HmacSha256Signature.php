<?php

namespace ApiClients\Tools\Psr7\Oauth1\Signature;

final class HmacSha256Signature extends HmacSignature
{
    /**
     * @return string
     */
    protected function getHashingAlgorithm(): string
    {
        return 'sha256';
    }
}
