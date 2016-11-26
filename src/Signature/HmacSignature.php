<?php declare(strict_types=1);

namespace ApiClients\Tools\Psr7\Oauth1\Signature;

use Psr\Http\Message\UriInterface;

abstract class HmacSignature extends Signature
{
    /**
     * @return string
     */
    abstract protected function getHashingAlgorithm(): string;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return sprintf('HMAC-%s', strtoupper($this->getHashingAlgorithm()));
    }

    /**
     * @param UriInterface $uri
     * @param array $parameters
     * @param string $method
     * @return string
     */
    public function sign(UriInterface $uri, array $parameters = [], string $method = 'POST'): string
    {
        $baseString = $this->generateBaseString($uri, $parameters, $method);

        return base64_encode($this->hash($baseString));
    }

    /**
     * @param UriInterface $uri
     * @param array $parameters
     * @param string $method
     * @return string
     */
    private function generateBaseString(UriInterface $uri, array $parameters = [], string $method = 'POST'): string
    {
        $baseString = [rawurlencode($method)];

        $scheme = $uri->getScheme();
        $host = $uri->getHost();
        $path = $uri->getPath();
        $port = $uri->getPort();

        $baseString[] = rawurlencode(is_null($port)
            ? sprintf('%s://%s%s', $scheme, $host, $path)
            : sprintf('%s://%s:%d%s', $scheme, $host, $port, $path));

        $data = [];

        parse_str($uri->getQuery(), $query);

        foreach (array_merge($query, $parameters) as $key => $value) {
            $data[rawurlencode($key)] = rawurlencode($value);
        }

        ksort($data);

        array_walk($data, function (&$value, $key) {
            $value = $key.'='.$value;
        });

        $baseString[] = rawurlencode(implode('&', $data));

        return implode('&', $baseString);
    }

    /**
     * @param $string
     * @return string
     */
    private function hash(string $string): string
    {
        return hash_hmac($this->getHashingAlgorithm(), $string, $this->getKey(), true);
    }
}
