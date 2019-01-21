<?php declare(strict_types=1);

namespace Stellar\Support;

use Stellar\Common\StaticClass;

/**
 * @see \UnitTests\Support\TypeTests
 */
final class Type extends StaticClass
{
    public const BOOL     = 'bool';

    public const INT      = 'int';

    public const FLOAT    = 'float';

    public const STRING   = 'string';

    public const ARRAY    = 'array';

    public const OBJECT   = 'object';

    public const RESOURCE = 'resource';

    public const NULL     = 'null';

    public static function isArrayable($var) : bool
    {
        return \is_array($var) || Obj::isArrayable($var);
    }

    /**
     * Check if we can determine the number of elements in a variable.
     */
    public static function isCountable($var) : bool
    {
        return \is_array($var) || $var instanceof \Countable;
    }

    /**
     * Determine if the variable can be safely cast to a string.
     */
    public static function isStringable($var) : bool
    {
        return \is_scalar($var) || Obj::isStringable($var);
    }

    public static function get($var) : string
    {
        $result = \strtolower(\gettype($var));
        switch ($result) {
            case 'boolean':
                $result = self::BOOL;
                break;

            case 'double':
                $result = self::FLOAT;
                break;

            case 'integer':
                $result = self::INT;
                break;

            // as of PHP 7.2.0
            case 'resource (closed)':
                $result = self::RESOURCE;
                break;

            case 'unknown type':
                if (Str::startsWith((string) $var, 'Resource id')) {
                    $result = self::RESOURCE;
                }
                break;
        }

        return $result;
    }

    public static function getDetailed($var) : string
    {
        $result = self::get($var);

        switch ($result) {
            case self::BOOL:
                $result .= ' (' . Bln::toString($var) . ')';
                break;

            case self::FLOAT:
            case self::INT:
                $result .= ' (' . $var . ')';
                break;

            case self::ARRAY:
                if (\is_callable($var)) {
                    $result .= '/callable';
                }
                break;

            case self::OBJECT:
                if ($var instanceof \Closure) {
                    $result .= '/callable';
                }
                elseif (\is_iterable($var)) {
                    $result .= '/iterable';
                }

                if (Obj::isAnonymous($var)) {
                    $result .= '/anonymous';
                }
                else {
                    $result .= ' (' . \get_class($var) . ')';
                }
                break;

            case self::RESOURCE:
                if (!\is_resource($var) || \strtolower(\gettype($var)) === 'resource (closed)') {
                    $result .= '/closed';
                }

                $result .= ' (' . \strtolower(\get_resource_type($var)) . ')';
                break;
        }

        return $result;
    }

    /**
     * Tries to cast any variable to an array by either calling a specific method or forcing the
     * variable.
     */
    public static function toArray($var) : ?array
    {
        $result = null;

        switch (true) {
            case \is_array($var):
                $result = $var;
                break;

            case Obj::isArrayable($var):
                /** @var \Stellar\Common\Contracts\ArrayableInterface $var */
                $result = $var->toArray();
                break;

            case ($var instanceof \Traversable):
                $result = \iterator_to_array($var, true);
                break;

            case \is_object($var):
                $result = \get_object_vars($var);
                break;
        }

        return $result;
    }

    /**
     * Tries to cast the variable to a string.
     */
    public static function toString($var) : ?string
    {
        $result = null;

        switch (true) {
            case \is_string($var):
                $result = $var;
                break;

            case \is_bool($var):
                $result = Bln::toString($var);
                break;

            case self::isStringable($var):
                $result = (string) $var;
                break;
        }

        return $result;
    }
}
