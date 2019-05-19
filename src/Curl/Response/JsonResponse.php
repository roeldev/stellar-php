<?php

namespace Stellar\Curl\Response;

use Stellar\Common\Contracts\ArrayableInterface;

class JsonResponse extends Response implements ArrayableInterface
{
    /** @var array<string, string> */
    protected $_data;

    public function __get($name) : ?string
    {
        return $this->_data[ $name ] ?? null;
    }

    public function __construct($requestResource,
                                array $usedOptions,
                                string $response)
    {
        parent::__construct($requestResource, $usedOptions, $response);
        $this->_data = \json_decode($this->_body, true);
    }

    public function toArray() : array
    {
        return $this->_data;
    }
}
