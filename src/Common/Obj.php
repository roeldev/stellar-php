<?php declare(strict_types=1);

namespace Stellar\Common;

use Stellar\Common\Contracts\ArrayableInterface;
use Stellar\Common\Contracts\InvokableInterface;
use Stellar\Common\Contracts\StringableInterface;
use Stellar\Common\Types\StaticClass;

/**
 * @see \UnitTests\Common\ObjectFnTests
 */
final class Obj extends StaticClass
{
    /**
     * Checks if the object is created as an anonymous class.
     *
     * @param object $obj
     */
    public static function isAnonymous($obj) : bool
    {
        return Cls::isAnonymous(\get_class($obj));
    }

    /**
     * Checks if the object implements the ArrayableInterface interface or has a `toArray()` method.
     *
     * @param object $obj
     */
    public static function isArrayable($obj) : bool
    {
        return $obj instanceof ArrayableInterface || \method_exists($obj, 'toArray');
    }

    /**
     * Checks if the object implements the InvokableInterface interface or has an `__invoke()` method.
     *
     * @param object $obj
     */
    public static function isInvokable($obj) : bool
    {
        return $obj instanceof InvokableInterface || \method_exists($obj, '__invoke');
    }

    /**
     * Checks if the object is a Closure or an invokable object.
     *
     * @param object $obj
     */
    public static function isCallable($obj) : bool
    {
        return $obj instanceof \Closure || self::isInvokable($obj);
    }

    /**
     * Checks if the object implements the Stringable interface or has a `__toString()` method.
     *
     * @param object $obj
     */
    public static function isStringable($obj) : bool
    {
        return $obj instanceof StringableInterface || \method_exists($obj, '__toString');
    }

    /**
     * @param object $obj
     */
    public static function namespaceOf($obj) : string
    {
        return Cls::namespaceOf(\get_class($obj));
    }
}
