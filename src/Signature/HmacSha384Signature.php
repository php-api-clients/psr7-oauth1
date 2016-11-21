<?php

namespace ApiClients\Tools\Psr7\Oauth1\Signature;

final class HmacSha384Signature extends HmacSignature
{
    /**
     * @return string
     */
    protected function getHashingAlgorithm(): string
    {
        return 'sha384';
    }
}
