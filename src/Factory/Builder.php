<?php declare(strict_types=1);

namespace Stellar\Factory;

use Stellar\Exceptions\Common\InvalidClass;

/**
 * @see:unit-test \UnitTests\Factory\BuilderTests
 */
class Builder
{
    /** @var string */
    protected $_class;

    /** @var mixed[] */
    protected $_args;

    public function __construct(string $class)
    {
        $this->_class = $class;
    }

    /**
     * @return $this
     */
    public function withArguments(...$args) : self
    {
        $this->_args = $args;

        return $this;
    }

    /**
     * Make sure the class to create extends/implements/uses a certain class/interface/trait.
     *
     * @return $this
     * @throws InvalidClass
     */
    public function subclassOf(string $subclass) : self
    {
        if (!\is_subclass_of($this->_class, $subclass, true)) {
            throw new InvalidClass($subclass, $this->_class);
        }

        return $this;
    }

    /**
     * Finish the build chain and create an instance of the class.
     *
     * @return object
     * @throws Exceptions\CreationException
     * @see Factory::create()
     */
    public function create()
    {
        return Factory::create($this->_class, $this->_args ?? []);
    }
}
