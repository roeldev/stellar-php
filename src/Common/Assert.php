<?php declare(strict_types=1);

namespace Stellar\Common;

/**
 * @see:unit-test \UnitTests\Common\AssertTests
 */
final class Assert extends StaticClass
{
    /**
     * Determine whether a variable is an empty string. Unlike PHP's `empty()` function, this method
     * does not evaluate `'0'` (a zero character) as empty.
     */
    public static function isEmptyString(?string ...$var) : bool
    {
        foreach ($var as $arg) {
            if ('' !== $arg && null !== $arg) {
                return false;
            }
        }

        return true;
    }

    /**
     * Indicates if a variable can be parsed as truthy.
     */
    public static function isTruthy($var) : bool
    {
        if (\is_string($var)) {
            $var = \strtolower(\trim($var));
        }

        return (true === $var
                || 1 === $var
                || '1' === $var
                || 'true' === $var
                || 'on' === $var
                || 'y' === $var
                || 'yes' === $var);
    }

    /**
     * Indicates if a variable can be parsed as falsy.
     */
    public static function isFalsy($var) : bool
    {
        if (\is_string($var)) {
            $var = \strtolower(\trim($var));
        }

        return (empty($var)
                || 'false' === $var
                || 'off' === $var
                || 'n' === $var
                || 'no' === $var);
    }

    public static function isOdd(int $int) : bool
    {
        return 0 !== $int && 1 === ($int % 2);
    }

    public static function isEven(int $int) : bool
    {
        return 0 !== $int && 0 === ($int % 2);
    }

    /**
     * Checks if the class or object is of an anonymous class.
     *
     * @param string|object $classOrObject
     */
    public static function isAnonymous($classOrObject) : bool
    {
        try {
            if (\is_object($classOrObject)) {
                $classOrObject = \get_class($classOrObject);
            }
            if (!\is_string($classOrObject)) {
                return false;
            }

            $result = 0 === \strpos($classOrObject, 'class@anonymous')
                      || (new \ReflectionClass($classOrObject))->isAnonymous();
        }
        catch (\Throwable $e) {
            $result = false;
        }

        return $result;
    }

    /**
     * Checks if the object implements the ArrayableInterface interface or has a `toArray()` method.
     */
    public static function isArrayable($obj) : bool
    {
        return $obj instanceof ArrayableInterface || \method_exists($obj, 'toArray');
    }

    /**
     * Check if we can determine the number of elements in a variable.
     */
    public static function isCountable($var) : bool
    {
        return \is_array($var) || $var instanceof \Countable;
    }

    /**
     * Checks if the object implements the InvokableInterface interface or has an `__invoke()`
     * method.
     */
    public static function isInvokable($obj) : bool
    {
        return $obj instanceof InvokableInterface || \method_exists($obj, '__invoke');
    }

    /**
     * Checks if the object is a Closure or an invokable object.
     */
    public static function isCallable($obj) : bool
    {
        return $obj instanceof \Closure || self::isInvokable($obj);
    }

    /**
     * Determine if the variable can be safely cast to a string.
     */
    public static function isStringable($var) : bool
    {
        return \is_scalar($var) ||
            $var instanceof StringableInterface ||
            \method_exists($var, '__toString');
    }
}
