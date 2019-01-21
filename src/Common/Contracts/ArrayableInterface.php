<?php declare(strict_types=1);

namespace Stellar\Common\Contracts;

interface ArrayableInterface
{
    /**
     * Get an array with keys and values representing the object.
     */
    public function toArray() : array;
}
