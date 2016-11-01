<?php

namespace ApiClients\Tools\Psr7\Oauth1\Signature;

class HmacMd5Signature extends HmacSignature
{
    protected function getHashingAlgorithm()
    {
        return 'md5';
    }
}
