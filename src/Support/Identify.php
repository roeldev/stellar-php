<?php declare(strict_types=1);

namespace Stellar\Support;

use Stellar\Common\Types\StaticClass;

/**
 * @see \UnitTests\Support\IdentifyTests
 */
final class Identify extends StaticClass
{
    public static function object($obj) : string
    {
        $class = \get_class($obj);

        return Cls::isAnonymous($class)
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

            case Obj::isInvokable($callable) :
                $result = self::object($callable);
                break;
        }

        return $result;
    }

    public static function resource($resource) : ?string
    {
        return \is_resource($resource) ? (string) $resource : null;
    }
}
