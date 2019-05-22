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

    /**
     * @return $this
     */
    public function withHost(string $host) : self
    {
        $this->_options[ \CURLOPT_PROXY ] = $host;

        return $this;
    }

    /**
     * @return $this
     */
    public function withPort(int $port) : self
    {
        $this->_options[ \CURLOPT_PROXYPORT ] = $port;

        return $this;
    }

    /**
     * @return $this
     */
    public function withType($type) : self
    {
        // ConstList::proxyTypes()
        if (!\in_array($type, Curl::proxyTypeConstants(), true)) {
            // todo: throw exception
        }

        $this->_options[ \CURLOPT_PROXYTYPE ] = $type;

        return $this;
    }

    /**
     * @return $this
     */
    public function withUserPassword(string $username, string $password) : self
    {
        $this->_options[ \CURLOPT_PROXYUSERPWD ] = $username . ':' . $password;

        return $this;
    }
}
