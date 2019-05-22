<?php declare(strict_types=1);

namespace Stellar\Factory;

use Stellar\Exceptions\Common\InvalidClass;
use Stellar\Exceptions\Common\InvalidSubclass;

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
     * @throws InvalidSubclass
     */
    public function subclassOf(string $subclass) : self
    {
        if (!\is_subclass_of($this->_class, $subclass, true)) {
            throw InvalidClass::factory($subclass, $this->_class)->create();
            // throw InvalidSubclass::create($subclass, $this->_class);
        }

        return $this;
    }

    /**
     * Finish the build chain and create an instance of the class.
     *
     * @see Factory::create()
     * @return object
     */
    public function create()
    {
        return Factory::create($this->_class, $this->_args ?? []);
    }
}
