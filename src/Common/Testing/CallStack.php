<?php declare(strict_types=1);

namespace Stellar\Common\Testing;

// (static) property access (get, set)
// (static) method calls
// debug backtrace
use Stellar\Common\Contracts\ArrayableInterface;

class CallStack implements ArrayableInterface
{
    /** @var object */
    protected $_owner;

    /** @var array[] */
    protected $_trace = [];

    /** @var array[] */
    protected $_methods = [];

    /**
     * @param object $owner
     */
    public function __construct($owner)
    {
        $this->_owner = $owner;
    }

    public function add(string $method, array $arguments) : self
    {
        if (!\array_key_exists($method, $this->_methods)) {
            $this->_methods[ $method ] = [];
        }

        $this->_methods[ $method ][] = \count($this->_trace);
        $this->_trace[] = \compact('method', 'arguments');

        return $this;
    }

    public function has(string $method) : bool
    {
        return \array_key_exists($method, $this->_methods);
    }

    public function get(string $method) : ?array
    {
        $result = null;
        if ($this->has($method)) {
            $result = [];
            foreach ($this->_methods[ $method ] as $i) {
                $result[] = $this->_trace[ $i ]['arguments'];
            }
        }

        return $result;
    }

    public function toArray() : array
    {
        return $this->_trace;
    }
}
