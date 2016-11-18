<?php

namespace ApiClients\Tools\Psr7\Oauth1\Signature;

final class HmacSha512Signature extends HmacSignature
{
    /**
     * @return string
     */
    protected function getHashingAlgorithm()
    {
        return 'sha512';
    }
}
