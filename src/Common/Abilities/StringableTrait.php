<?php declare(strict_types=1);

namespace Stellar\Common\Abilities;

/**
 * Gives an object some basic functionality so it can be cast to a string. As a default the FQCN of the object is
 * returned. Change the `__toString()` method to allow for a different string output.
 *
 * @see:unit-test \UnitTests\Common\Traits\ToStringTests
 */
trait StringableTrait
{
    abstract public function __toString() : string;

    /**
     * This method casts the object as a string, eventually calling the `__toString()` magic method. It is here simply
     * to allow a consistent way of casting an object, and therefore should not be overridden.
     *
     * @see $this->__toString() :alias:
     */
    final public function toString() : string
    {
        return $this->__toString();
    }
}
