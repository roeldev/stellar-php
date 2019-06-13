<?php

namespace Stellar\Curl;

use Stellar\Common\Contracts\ArrayableInterface;
use Stellar\Exceptions\Common\InvalidType;
use Stellar\Common\Type;

class Info implements ArrayableInterface
{
    /** @var resource */
    protected $_resource;

    /** @var int[] */
    protected $_options;

    protected $_info;

    protected function _filterOptions(array $options) : array
    {
        $constants = Curl::infoConstants();

        $result = [];
        foreach ($options as $option) {
            if (\is_string($option) && \array_key_exists($option, $constants)) {
                $result[] = \constant($option);
            }
            elseif (\is_int($option) && \in_array($option, $constants, true)) {
                $result[] = $option;
            }
        }

        return $result;
    }

    public function __construct($resource, ...$options)
    {
        if (!\is_resource($resource)) {
            throw new InvalidType('resource (curl)', Type::details($resource));
        }

        $this->_resource = $resource;
        $this->read(...$options);
    }

    public function read(... $options) : self
    {
        $options = $this->_filterOptions($options);
        $this->_info = \array_merge($this->_info, \curl_getinfo($this->_resource, $options));

        return $this;
    }

    public function toArray() : array
    {
        return $this->_info;
    }
}
