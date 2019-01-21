<?php declare(strict_types=1);

namespace Stellar\Curl;

use Stellar\Common\StaticClass;
use Stellar\Constants\ConstList;
use Stellar\Curl\Options\Options;

/**
 * @see https://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol#Request_methods
 * @see https://restfulapi.net/http-methods/
 */
class Curl extends StaticClass
{
    public const METHOD_GET    = 'GET';

    public const METHOD_HEAD   = 'HEAD';

    public const METHOD_POST   = 'POST';

    public const METHOD_PUT    = 'PUT';

    public const METHOD_DELETE = 'DELETE';

    public const METHOD_PATCH  = 'PATCH';

    /** @var array<string,array> */
    private static $_constList = [];

    private static function _constList(string $prefix, array $add = []) : array
    {
        if (!\array_key_exists($prefix, self::$_constList)) {
            $list = ConstList::startingWith($prefix, 'curl');
            foreach ($add as $constant) {
                $list[ $constant ] = \constant($constant);
            }

            self::$_constList[ $prefix ] = $list;
        }

        return self::$_constList[ $prefix ];
    }

    public static function errorConstants() : array
    {
        return self::_constList('CURLE_');
    }

    public static function infoConstants() : array
    {
        return self::_constList('CURLINFO_');
    }

    public static function multiConstants() : array
    {
        return self::_constList('CURLM_');
    }

    public static function optionConstants() : array
    {
        return self::_constList('CURLOPT_', [ 'CURLINFO_HEADER_OUT' ]);
    }

    public static function proxyTypeConstants() : array
    {
        return self::_constList('CURLPROXY_');
    }

    public static function multi(Request ... $request) : Multi
    {
        return new Multi($request);
    }

    public static function request(string $method, string $url, array $options = []) : Request
    {
        /** @var Request $request */
        $request = Factory::instance()->createRequest($method, $url);
        if (!empty($options)) {
            $request->with(new Options($options));
        }

        return $request;
    }

    /**
     * The GET method requests a representation of the specified resource. Requests using GET
     * should only retrieve data and should have no other effect.
     */
    public static function get(string $url, array $queryParams = []) : Request
    {
        /** @var Request $request */
        $request = Factory::instance()->createRequest(self::METHOD_GET, $url);
        $request->withQueryParams($queryParams);

        return $request;
    }

    /**
     * The HEAD method asks for a response identical to that of a GET request, but without the
     * response body. This is useful for retrieving meta-information written in response
     * headers, without having to transport the entire content.
     */
    public static function head(string $url, array $queryParams = []) : Request
    {
        /** @var Request $request */
        $request = Factory::instance()->createRequest(self::METHOD_HEAD, $url);
        $request->withQueryParams($queryParams);

        return $request;
    }

    /**
     * The POST method requests that the server accept the entity enclosed in the request as a
     * new subordinate of the web resource identified by the URI.
     */
    public static function post(string $url, array $postFields) : Request
    {
        /** @var Request $request */
        $request = Factory::instance()->createRequest(self::METHOD_POST, $url);
        $request->withPostFields($postFields);

        return $request;
    }

    /**
     * The PUT method requests that the enclosed entity be stored under the supplied URI. If the
     * URI refers to an already existing resource, it is modified; if the URI does not point
     * to an existing resource, then the server can create the resource with that URI.
     */
    public static function put(string $url, array $postFields) : Request
    {
        /** @var Request $request */
        $request = Factory::instance()->createRequest(self::METHOD_PUT, $url);
        $request->withPostFields($postFields);

        return $request;
    }

    /**
     * The DELETE method deletes the specified resource.
     */
    public static function delete(string $url) : Request
    {
        return Factory::instance()->createRequest(self::METHOD_DELETE, $url);
    }

    /**
     * The PATCH method applies partial modifications to a resource.
     */
    public static function patch(string $url) : Request
    {
        return Factory::instance()->createRequest(self::METHOD_PATCH, $url);
    }
}
