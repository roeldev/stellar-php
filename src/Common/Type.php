<?php declare(strict_types=1);

namespace Stellar\Common;

/**
 * @see \UnitTests\Common\TypeTests
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
                if (StringUtil::startsWith((string) $var, 'Resource id')) {
                    $result = self::RESOURCE;
                }
                break;
        }

        return $result;
    }

    public static function details($var) : string
    {
        $result = self::get($var);
        switch ($result) {
            case self::BOOL:
            case self::FLOAT:
            case self::INT:
                $result .= ' (' . Stringify::scalar($var) . ')';
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

                if (Assert::isAnonymous($var)) {
                    $result .= '/anonymous';
                }
                else {
                    $result .= ' (' . \get_class($var) . ')';
                }
                break;

            case self::RESOURCE:
                if (!\is_resource($var) || 'resource (closed)' === \strtolower(\gettype($var))) {
                    $result .= '/closed';
                }

                $result .= ' (' . \strtolower(\get_resource_type($var)) . ')';
                break;
        }

        return $result;
    }
}
