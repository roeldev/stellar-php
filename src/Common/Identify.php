<?php declare(strict_types=1);

namespace Stellar\Common;

/**
 * Create id's for the given types.
 *
 * @see \UnitTests\Common\IdentifyTests
 */
final class Identify extends StaticClass
{
    public static function any($var) : ?string {
        if (\is_callable($var)) {
            return self::callable($var);
        }

        return self::object($var) ?? self::resource($var);
    }

    /**
     * @param object $obj
     */
    public static function object($obj) : ?string
    {
        if (!\is_object($obj)) {
            return null;
        }

        $class = \get_class($obj);

        return Assert::isAnonymous($class)
            ? $class
            : $class . '_' . \md5(\spl_object_hash($obj));
    }

    public static function callable(callable $callable) : ?string
    {
        $result = null;
        switch (true) {
            case ($callable instanceof \Closure):
                $result = self::object($callable);
                break;

            case \is_array($callable):
                if (\is_object($callable[0])) {
                    $result = self::object($callable[0]) . '->' . $callable[1];
                }
                elseif (\is_string($callable[0])) {
                    $result = $callable[0] . '::' . $callable[1];
                }

                break;

            case \is_string($callable):
                $result = $callable;
                break;

            case Assert::isInvokable($callable):
                $result = self::object($callable);
                break;
        }

        return $result;
    }

    /**
     * @param resource $resource
     */
    public static function resource($resource) : ?string
    {
        return \is_resource($resource) ? (string) $resource : null;
    }
}
