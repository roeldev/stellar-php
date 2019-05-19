<?php declare(strict_types=1);

namespace Stellar\Common;

use Stellar\Common\Types\StaticClass;

/**
 * @see \UnitTests\Common\ClassFnTests
 */
final class Cls extends StaticClass
{
    public static function getUsedTraits(string $class, array &$result = []) : array
    {
        $traits = \class_uses($class);
        $result[ $class ] = \array_values($traits);

        foreach ($traits as $trait) {
            if (\array_key_exists($trait, $result)) {
                continue;
            }

            self::getUsedTraits($trait, $result);
        }

        return $result;
    }

    /**
     * Checks if the class is an anonymous class.
     */
    public static function isAnonymous(string $class) : ?bool
    {
        try {
            $result = \strpos($class, 'class@anonymous') === 0
                      || (new \ReflectionClass($class))->isAnonymous();
        }
        catch (\Throwable $e) {
            $result = false;
        }

        return $result;
    }

    public static function exists(?string $class, $autoload = true) : bool
    {
        return $class && \class_exists($class, $autoload);
    }

    public static function namespaceOf(string $class) : string
    {
        $lastPos = \strrpos($class, '\\');

        return $lastPos ? \substr($class, 0, $lastPos) : '';
    }
}
