<?php declare(strict_types=1);

namespace Stellar\Common\Contracts;

/**
 * The interface streamlines the implementation of singletons by providing a method to retrieve an
 * instance of the object, preferably through a Container.
 */
interface SingletonInterface
{
    /**
     * Creates and/or returns an instance of itself.
     *
     * @return static
     */
    public static function instance();
}
