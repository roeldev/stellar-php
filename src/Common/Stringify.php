<?php declare(strict_types=1);

namespace Stellar\Common;

/**
 * Get the string value of any type.
 *
 * @see \UnitTests\Support\IdentifyTests
 */
final class Stringify extends StaticClass
{
    /**
     * Tries to cast the variable to a string.
     */
    public static function any($var) : ?string
    {
        return self::scalar($var) ??
            (Assert::isStringable($var) ? (string) $var : null);
    }

    /**
     * Get the string value of the given boolean.
     */
    public static function bool(bool $bool) : string
    {
        return $bool ? 'true' : 'false';
    }

    /**
     * Get the string value of the given scalar.
     *
     * @param bool|float|int|string
     */
    public static function scalar($var) : ?string
    {
        if (!\is_scalar($var)) {
            return null;
        }

        return \is_bool($var) ? self::bool($var) : (string) $var;
    }

    /**
     * @param object|string $var
     */
    public static function objectClass($var) : ?string
    {
        if (\is_object($var)) {
            $var = \get_class($var);
        }

        return \is_string($var) ? $var : null;
    }
}
