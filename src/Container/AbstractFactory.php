<?php declare(strict_types=1);

namespace Stellar\Container;

use Stellar\Common\Contracts\SingletonInterface;

abstract class AbstractFactory implements SingletonInterface
{
    /**
     * @return static
     */
    public static function instance()
    {
        return Registry::singleton(static::class);
    }
}
