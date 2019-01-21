<?php declare(strict_types=1);

namespace Stellar\Common\Contracts;

interface StringableInterface
{
    /**
     * This method allows a class to decide how it will react when it is treated like a string.
     *
     * @see http://php.net/manual/en/language.oop5.magic.php#object.tostring
     * @return string
     */
    public function __toString();

    /**
     * Cast the object as a string, eventcually calling the `__toString()` magic method. It is here simply to allow a
     * consistent way of casting an objet.
     */
    public function toString() : string;
}
