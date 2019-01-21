<?php declare(strict_types=1);

namespace Stellar\Common\Contracts;

interface LockableInterface
{
    /**
     * Indicates whether the object is locked.
     */
    public function isLocked() : bool;

    /**
     * Indicates whether it is possible to unlock the object.
     */
    public function isUnlockable() : bool;

    /**
     * Lock the object so its values cannot be changed from the outside.
     *
     * @param bool $permanent Set the object in a permanent locked state when true.
     */
    public function lock(bool $permanent = false) : bool;

    /**
     * Unlocks the object when not in a permanent locked state.
     */
    public function unlock() : bool;
}
