<?php declare(strict_types=1);

namespace Stellar\Common;

/**
 * @see:unit-test \UnitTests\Common\TypeTests
 */
final class Type extends StaticClass
{
    public const BOOL = 'bool';

    public const INT = 'int';

    public const FLOAT = 'float';

    public const STRING = 'string';

    public const ARRAY = 'array';

    public const OBJECT = 'object';

    public const RESOURCE = 'resource';

    public const NULL = 'null';

    /**
     * List of aliases of variable types.
     */
    public const ALIASES = [
        'boolean' => self::BOOL,
        'double' => self::FLOAT,
        'integer' => self::INT,
        'resource (closed)' => self::RESOURCE,
    ];

    /**
     * Get the type of the variable.
     */
    public static function get($var) : string
    {
        $result = \strtolower(\gettype($var));
        $aliases = self::ALIASES;

        if (isset($aliases[ $result ])) {
            return $aliases[ $result ];
        }
        if ($result == 'unknown type' && StringUtil::startsWith((string) $var, 'Resource id')) {
            $result = self::RESOURCE;
        }

        return $result;
    }

    /**
     * Get a detailed version of the type of the variable. This includes if the type is a callable,
     * iterable or an anonymous class.
     */
    public static function details($var) : string
    {
        $result = self::get($var);
        $format = '%s';
        $args = [ $result ];

        switch ($result) {
            case self::BOOL:
            case self::FLOAT:
            case self::INT:
                $format = '%s (%s)';
                $args[] = Stringify::scalar($var);
                break;

            case self::ARRAY:
                if (\is_callable($var)) {
                    $format = '%s/%s';
                    $args[] = 'callable';
                }
                break;

            case self::OBJECT:
                $format = '%s (%s)';
                $args[] = Assert::isAnonymous($var) ? 'anonymous' : \get_class($var);

                if ($var instanceof \Closure) {
                    $args[0] .= '/callable';
                }
                elseif (\is_iterable($var)) {
                    $args[0] .= '/iterable';
                }
                break;

            case self::RESOURCE:
                $format = '%s (%s)';
                $args[] = \strtolower(\get_resource_type($var));

                if (!\is_resource($var) || 0 === \strcasecmp(\gettype($var), 'resource (closed)')) {
                    $args[0] .= '/closed';
                }
                break;
        }

        return \vsprintf($format, $args);
    }
}
