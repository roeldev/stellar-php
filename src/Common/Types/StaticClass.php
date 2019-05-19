<?php declare(strict_types=1);

namespace Stellar\Common\Types;

/**
 * Basic pattern that forces the class to be only used in a static way as the constructor is private and cannot be
 * called.
 */
abstract class StaticClass
{
    /**
     * By making the constructor private and final we make sure it cannot be called, thus a new instance cannot be
     * created.
     *
     * @codeCoverageIgnore
     */
    final private function __construct()
    {
    }
}
