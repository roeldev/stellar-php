<?php declare(strict_types=1);

namespace Stellar\Constants;

use Stellar\Common\Contracts\ArrayableInterface;
use Stellar\Exceptions\Common\InvalidClass;
use Stellar\Exceptions\Common\UndeclaredClass;

/**
 * @see:unit-test \UnitTests\Constants\ClassConstListTests
 */
class ClassConstList implements ArrayableInterface, \Countable
{
    /**
     * Name of the class who's constants are listed.
     *
     * @var string
     */
    protected $_class;

    /**
     * An array with the names of the constants and their associated values.
     *
     * [ CONST_NAME => value ]
     *
     * @var array<string, string>
     */
    protected $_list = [];

    /**
     * @var string[]
     */
    protected $_names;

    /**
     * @throws UndeclaredClass
     */
    public function __construct(string $class)
    {
        try {
            $this->_list = (new \ReflectionClass($class))->getConstants();
        }
        catch (\ReflectionException $previous) {
            throw new UndeclaredClass($class, $previous);
        }

        $this->_class = $class;
        $this->_names = \array_keys($this->_list);
        foreach ($this->_names as $i => $const) {
            $this->_names[ $i ] = $class . '::' . $const;
        }
    }

    /**
     * Get the FQCN of the owner class.
     */
    public function getOwnerClass() : string
    {
        return $this->_class;
    }

    /**
     * Get an array with constant names and their associated (custom) values.
     */
    public function getList() : array
    {
        return $this->_list;
    }

    /**
     * Determines if the argument is either a valid name or valid value of one of the constants.
     */
    public function has($nameOrValue) : bool
    {
        return $this->hasName((string) $nameOrValue) || $this->hasValue($nameOrValue);
    }

    /**
     * Determines if the argument is the name of one of the constants.
     */
    public function hasName(?string $name) : bool
    {
        return ($name && \array_key_exists($name, $this->_list))
               || \in_array((string) $name, $this->_names, true);
    }

    /**
     * Determines if the argument is the exact value of one of the constants.
     */
    public function hasValue($value) : bool
    {
        return \in_array($value, $this->_list, true);
    }

    /**
     * Get the name of the const that's associated with the given value.
     */
    public function nameOf($value) : ?string
    {
        return \array_search($value, $this->_list, true) ?: null;
    }

    /**
     * Gets the constant name (including FQCN) if the value is defined.
     */
    public function constOf($value) : ?string
    {
        $name = $this->nameOf($value);

        return $name ? $this->_class . '::' . $name : null;
    }

    /**
     * @return mixed|null
     * @throws InvalidClass
     */
    public function valueOf($var)
    {
        $result = null;
        if (\is_string($var)) {
            [ $class, $var ] = ConstUtil::split($var) ?? [ null, null ];
            if ($class !== $this->_class) {
                throw new InvalidClass($this->_class, $class ?? $var);
            }
        }

        return $var ? ($this->_list[ $var ] ?? null) : null;
    }

    /**
     * Returns the number of defined constants within the owner class.
     */
    public function count() : int
    {
        return \count($this->_list);
    }

    /**
     * Get the defined constants (including FQCN) and their associated values of the owner class.
     */
    public function toArray() : array
    {
        return \array_combine($this->_names, $this->_list);
    }
}
