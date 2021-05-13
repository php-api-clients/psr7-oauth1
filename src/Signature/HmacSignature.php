<?php

declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Signature;

use Psr\Http\Message\UriInterface;

use function array_merge;
use function array_walk;
use function base64_encode;
use function hash_hmac;
use function implode;
use function parse_str;
use function rawurlencode;
use function Safe\ksort;
use function Safe\sprintf;
use function strtoupper;

abstract class HmacSignature extends Signature
{
    abstract protected function getHashingAlgorithm(): string;

    final public function getMethod(): string
    {
        return sprintf('HMAC-%s', strtoupper($this->getHashingAlgorithm()));
    }

    /**
     * @param array<string, string> $parameters
     */
    final public function sign(UriInterface $uri, array $parameters = [], string $method = 'POST'): string
    {
        $baseString = $this->generateBaseString($uri, $parameters, $method);

        return base64_encode($this->hash($baseString));
    }

    /**
     * @param array<string, string|int> $parameters
     */
    private function generateBaseString(UriInterface $uri, array $parameters = [], string $method = 'POST'): string
    {
        $baseString = [rawurlencode($method)];

        $scheme = $uri->getScheme();
        $host   = $uri->getHost();
        $path   = $uri->getPath();
        $port   = $uri->getPort();

        $baseString[] = rawurlencode($port === null
            ? sprintf('%s://%s%s', $scheme, $host, $path)
            : sprintf('%s://%s:%d%s', $scheme, $host, $port, $path));

        $data = [];

        parse_str($uri->getQuery(), $query);

        foreach (array_merge($query, $parameters) as $key => $value) {
            $data[rawurlencode($key)] = rawurlencode($value);
        }

        ksort($data);

        array_walk($data, static function (string &$value, string $key): void {
            $value = $key . '=' . $value;
        });

        $baseString[] = rawurlencode(implode('&', $data));

        return implode('&', $baseString);
    }

    private function hash(string $string): string
    {
        return hash_hmac($this->getHashingAlgorithm(), $string, $this->getKey(), true);
    }
}
