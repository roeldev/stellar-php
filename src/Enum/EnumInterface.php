<?php declare(strict_types=1);

namespace Stellar\Enum;

use Stellar\Common\Contracts\StringableInterface;
use Stellar\Constants\Contracts\ClassConstantInterface;

/**
 * Definition of the static methods an Enumerable class should have.
 */
interface EnumInterface extends ClassConstantInterface, StringableInterface
{
    public static function enum() : EnumerablesList;

    /**
     * Get an array with all types and their values as [name => value].
     */
    public static function list() : array;

    /**
     * Get the full name (class and constant) of the value from the enum class.
     */
    public static function constOf($value) : ?string;

    /**
     * Get the (constant) name associated with the type value.
     */
    public static function nameOf($type) : ?string;

    /**
     * Get the value associated with the type value.
     */
    public static function valueOf($type);
}
