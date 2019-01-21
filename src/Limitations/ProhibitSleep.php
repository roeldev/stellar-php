<?php declare(strict_types=1);

namespace Stellar\Limitations;

use Stellar\Limitations\Exceptions\SerializationProhibited;

/**
 * @see \UnitTests\Limitations\ProhibitSleepTests
 */
trait ProhibitSleep
{
    /**
     * Do not allow an object to 'sleep' by serializing it.
     *
     * @see http://php.net/manual/en/language.oop5.magic.php#object.sleep
     * @throws SerializationProhibited
     */
    final public function __sleep()
    {
        throw SerializationProhibited::factory(static::class)->create();
    }
}
