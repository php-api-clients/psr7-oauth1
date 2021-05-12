<?php

declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Signature;

final class HmacSha384Signature extends HmacSignature
{
    protected function getHashingAlgorithm(): string
    {
        return 'sha384';
    }
}
