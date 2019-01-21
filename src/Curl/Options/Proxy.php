<?php declare(strict_types=1);

namespace Stellar\Curl\Options;

use Stellar\Curl\Curl;

class Proxy extends AbstractOptions
{
    public function __construct(string $host, ?int $port = null)
    {
        $this->withHost($host);

        if (null !== $port) {
            $this->withPort($port);
        }
    }

    public function withHost(string $host)
    {
        $this->_options[ \CURLOPT_PROXY ] = $host;
    }

    public function withPort(int $port)
    {
        $this->_options[ \CURLOPT_PROXYPORT ] = $port;

        return $this;
    }

    public function withType($type) : self
    {
        if (!\in_array($type, Curl::proxyTypeConstants(), true)) {
            // todo: throw exception
        }

        $this->_options[ \CURLOPT_PROXYTYPE ] = $type;

        return $this;
    }

    public function withUserPassword(string $username, string $password)
    {
        $this->_options[ \CURLOPT_PROXYUSERPWD ] = $username . ':' . $password;

        return $this;
    }
}
