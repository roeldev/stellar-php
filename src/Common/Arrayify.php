<?php declare(strict_types=1);

namespace Stellar\Common;

/**
 * @see \UnitTests\Common\ArrayifyTests
 */
final class Arrayify extends StaticClass
{
    public static function any($var) : ?array
    {
        if (\is_array($var)) {
            return $var;
        }
        elseif (Assert::isArrayable($var)) {
            /** @var \Stellar\Common\Contracts\ArrayableInterface $var */
            return $var->toArray();
        }
        elseif (\is_object($var)) {
            return $var instanceof \Traversable
                ? self::traversable($var)
                : \get_object_vars($var);
        }

        return null;
    }

    public static function traversable(\Traversable $var) : array
    {
        return \iterator_to_array($var, true);
    }

    public static function iterable(iterable $var) : ?array
    {
        if (\is_array($var)) {
            return $var;
        }

        return $var instanceof \Traversable ? self::traversable($var) : null;
    }
}
