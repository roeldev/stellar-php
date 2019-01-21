<?php declare(strict_types=1);

namespace Stellar\Curl\Options;

use Stellar\Support\Arr;

class Cookie extends AbstractOptions
{
    /**
     * @param array<string,string> $cookies
     */
    public function withCookies(array $cookies) : self
    {
        $this->_options[ \CURLOPT_COOKIE ] = \implode('; ', Arr::join('= ', $cookies));

        return $this;
    }

    public function withCookieFile(string $cookieFile) : self
    {
        $this->_options[ \CURLOPT_COOKIEFILE ] = $cookieFile;

        return $this;
    }

    public function withCookieJar(string $cookieJar) : self
    {
        $this->_options[ \CURLOPT_COOKIEJAR ] = $cookieJar;

        return $this;
    }
}
