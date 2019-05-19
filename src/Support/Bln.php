<?php declare(strict_types=1);

namespace Stellar\Support;

use Stellar\Common\Types\StaticClass;

/**
 * @see \UnitTests\Support\BoolFnTests
 */
final class Bln extends StaticClass
{
    /**
     * @param mixed $var
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
     * @param mixed $var
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

    /**
     * Returns the string representation of the given boolean.
     */
    public static function toString(bool $bool) : string
    {
        return $bool ? 'true' : 'false';
    }
}
