<?php

namespace ApiClients\Tools\Psr7\Oauth1\Signature;

class HmacSha512Signature extends HmacSignature
{
    protected function getHashingAlgorithm()
    {
        return 'sha512';
    }
}
