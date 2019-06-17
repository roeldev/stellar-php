<?php declare(strict_types=1);

namespace Stellar\Curl\Response;

use Stellar\Common\Contracts\ArrayableInterface;
use Stellar\Curl\Contracts\RequestInterface;

class JsonResponse extends Response implements ArrayableInterface
{
    /** @var array<string, string> */
    protected $_data;

    public function __get($name) : ?string
    {
        return $this->_data[ $name ] ?? null;
    }

    public function __construct(RequestInterface $request, string $response)
    {
        parent::__construct($request, $response);
        $this->_data = \json_decode($this->_body, true);
    }

    public function toArray() : array
    {
        return $this->_data;
    }
}
