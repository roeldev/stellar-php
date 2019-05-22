<?php declare(strict_types=1);

namespace Stellar\Curl\Response;

use Stellar\Curl\Contracts\ResponseInterface;
use Stellar\Exceptions\Common\InvalidType;
use Stellar\Http\Headers\HeaderLines;
use Stellar\Common\Type;

class Response implements ResponseInterface
{
    /** @var int */
    protected $_httpCode;

    /** @var ?string[] */
    protected $_headerLines;

    /** @var ?string */
    protected $_body;

    public function __construct($requestResource, array $usedOptions, string $response)
    {
        if (!\is_resource($requestResource)) {
            throw InvalidType::factory('resource (curl)', Type::details($requestResource))
                ->create();
        }

        $this->_httpCode = \curl_getinfo($requestResource, \CURLINFO_HTTP_CODE);

        if ($usedOptions[ \CURLOPT_NOBODY ] ?? false) {
            $this->_headerLines = HeaderLines::parse($response);
        }
        elseif ($usedOptions[ \CURLOPT_HEADER ] ?? false) {
            $headerSize = \curl_getinfo($requestResource, \CURLINFO_HEADER_SIZE);
            $this->_headerLines = HeaderLines::parse(\substr($response, 0, $headerSize));
            $this->_body = \trim(\substr($response, $headerSize));
        }
        else {
            $this->_body = \trim($response);
        }
    }

    public function getHttpCode() : int
    {
        return $this->_httpCode;
    }

    /**
     * Get the headers per line from the request.
     */
    public function getHeaderLines() : ?array
    {
        return $this->_headerLines;
    }

    /**
     * Get the body from the request.
     */
    public function getBody() : ?string
    {
        return $this->_body;
    }
}
