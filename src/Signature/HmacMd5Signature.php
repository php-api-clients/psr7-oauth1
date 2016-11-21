<?php

namespace ApiClients\Tools\Psr7\Oauth1\Signature;

final class HmacMd5Signature extends HmacSignature
{
    /**
     * @return string
     */
    protected function getHashingAlgorithm(): string
    {
        return 'md5';
    }
}
