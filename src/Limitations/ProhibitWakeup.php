<?php declare(strict_types=1);

namespace Stellar\Limitations;

use Stellar\Limitations\Exceptions\UnserializationProhibited;

/**
 * @see \UnitTests\Limitations\ProhibitWakeupTests
 */
trait ProhibitWakeup
{
    /**
     * Do not allow 'waking up' the object when unserializing it.
     *
     * @see http://php.net/manual/en/language.oop5.magic.php#object.sleep
     * @throws UnserializationProhibited
     */
    final public function __wakeup()
    {
        throw UnserializationProhibited::factory(static::class)->create();
    }
}
