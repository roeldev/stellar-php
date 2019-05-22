<?php declare(strict_types=1);

namespace Stellar\Common;

/**
 * @see:unit-test \UnitTests\Common\ClassUtilTests
 */
final class ClassUtil extends StaticClass
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
     * @param string|object $classOrObject
     */
    public static function getNamespaceOf($classOrObject) : ?string
    {
        if (\is_object($classOrObject)) {
            $classOrObject = \get_class($classOrObject);
        }
        if (!\is_string($classOrObject)) {
            return null;
        }

        $lastPos = \strrpos($classOrObject, '\\');

        return $lastPos ? \substr($classOrObject, 0, $lastPos) : '';
    }

    public static function exists(?string $class, $autoload = true) : bool
    {
        return $class && \class_exists($class, $autoload);
    }
}
