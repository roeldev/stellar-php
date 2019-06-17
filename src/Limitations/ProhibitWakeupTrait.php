<?php declare(strict_types=1);

namespace Stellar\Limitations;

use Stellar\Limitations\Exceptions\UnserializationProhibited;

/**
 * @see:unit-test \UnitTests\Limitations\ProhibitWakeupTests
 */
trait ProhibitWakeupTrait
{
    /**
     * Do not allow 'waking up' the object when unserializing it.
     *
     * @see http://php.net/manual/en/language.oop5.magic.php#object.sleep
     * @throws UnserializationProhibited
     */
    final public function __wakeup()
    {
        throw new UnserializationProhibited(static::class);
    }
}
