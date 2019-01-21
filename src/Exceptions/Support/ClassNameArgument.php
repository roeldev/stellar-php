<?php declare(strict_types=1);

namespace Stellar\Exceptions\Support;

trait ClassNameArgument
{
    /**
     * @param object|string $var Object or class name
     */
    protected static function _classNameArgument($var) : string
    {
        return \is_object($var) ? \get_class($var) : (string) $var;
    }
}
