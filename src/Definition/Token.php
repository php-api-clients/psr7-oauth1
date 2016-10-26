<?php

namespace ApiClients\Tools\Psr7\Oauth1\Definition;

interface Token
{
    /**
     * @return string
     */
    public function getToken();

    /**
     * @return string
     */
    public function __toString();
}
