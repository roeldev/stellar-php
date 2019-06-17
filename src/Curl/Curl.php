<?php declare(strict_types=1);

namespace Stellar\Curl;

use Stellar\Common\StaticClass;
use Stellar\Curl\Options\Options;
use Stellar\Curl\Request\MultiRequest;
use Stellar\Curl\Request\Request;

/**
 * @see https://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol#Request_methods
 * @see https://restfulapi.net/http-methods/
 */
final class Curl extends StaticClass
{
    public const METHOD_GET = 'GET';

    public const METHOD_HEAD = 'HEAD';

    public const METHOD_POST = 'POST';

    public const METHOD_PUT = 'PUT';

    public const METHOD_DELETE = 'DELETE';

    public const METHOD_PATCH = 'PATCH';

    public static function factory() : Factory
    {
        return Factory::instance();
    }

    public static function multi(Request ...$request) : MultiRequest
    {
        return new MultiRequest(...$request);
    }

    public static function request(string $method, string $url, array $options = []) : Request
    {
        /** @var Request $request */
        $request = self::factory()->createRequest($method, $url);

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
        return self::request(self::METHOD_GET, $url)
            ->withQueryParams($queryParams);
    }

    /**
     * The HEAD method asks for a response identical to that of a GET request, but without the
     * response body. This is useful for retrieving meta-information written in response
     * headers, without having to transport the entire content.
     */
    public static function head(string $url, array $queryParams = []) : Request
    {
        return self::request(self::METHOD_HEAD, $url)
            ->withQueryParams($queryParams);
    }

    /**
     * The POST method requests that the server accept the entity enclosed in the request as a
     * new subordinate of the web resource identified by the URI.
     */
    public static function post(string $url, array $postFields) : Request
    {
        return self::request(self::METHOD_POST, $url)
            ->withPostFields($postFields);
    }

    /**
     * The PUT method requests that the enclosed entity be stored under the supplied URI. If the
     * URI refers to an already existing resource, it is modified; if the URI does not point
     * to an existing resource, then the server can create the resource with that URI.
     */
    public static function put(string $url, array $postFields) : Request
    {
        return self::request(self::METHOD_PUT, $url)
            ->withPostFields($postFields);
    }

    /**
     * The DELETE method deletes the specified resource.
     */
    public static function delete(string $url) : Request
    {
        return self::request(self::METHOD_DELETE, $url);
    }

    /**
     * The PATCH method applies partial modifications to a resource.
     */
    public static function patch(string $url) : Request
    {
        return self::request(self::METHOD_PATCH, $url);
    }
}
