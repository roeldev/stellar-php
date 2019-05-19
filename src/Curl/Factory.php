<?php declare(strict_types=1);

namespace Stellar\Curl;

use Psr\Http\Message\UriInterface;
use Stellar\Common\Contracts\SingletonInterface;
use Stellar\Container\Registry;
use Stellar\Curl\Request\Request;
use Stellar\Curl\Response\Response;
use Stellar\Exceptions\Common\InvalidClass;
use Stellar\Exceptions\Common\InvalidType;
use Stellar\Common\Type;

/**
 * todo: make psr7 + psr17 compatible
 */
class Factory implements SingletonInterface
{
    public static function instance() : self
    {
        return Registry::singleton(static::class);
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidClass
     * @throws InvalidType
     */
    public function createRequest(string $method, $uri) : Request
    {
        if (\is_object($uri) && !($uri instanceof UriInterface)) {
            throw InvalidClass::factory(UriInterface::class, $uri, 'uri')->create();
        }
        elseif (!\is_string($uri)) {
            throw InvalidType::factory('string', Type::get($uri), 'uri')->create();
        }

        $options = [
            \CURLOPT_URL            => null,
            \CURLOPT_FOLLOWLOCATION => false,
            \CURLOPT_TIMEOUT        => 30,
            \CURLOPT_HEADER         => false,

            // default options that should not be changed
            \CURLOPT_RETURNTRANSFER => true,
            \CURLOPT_FAILONERROR    => false,
        ];

        $request = new Request($options);
        $request->withMethod($method);
        $request->withUrl((string) $uri);

        return $request;
    }
}
