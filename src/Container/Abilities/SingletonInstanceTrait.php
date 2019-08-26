<?php declare(strict_types=1);

namespace Stellar\Container\Abilities;

use Stellar\Container\Registry;

trait SingletonInstanceTrait
{
    /**
     * @return static
     */
    public static function instance()
    {
        return Registry::singleton(static::class);
    }
}
