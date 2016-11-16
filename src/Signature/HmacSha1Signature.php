<?php

namespace ApiClients\Tools\Psr7\Oauth1\Signature;

final class HmacSha1Signature extends HmacSignature
{
    protected function getHashingAlgorithm()
    {
        return 'sha1';
    }
}
