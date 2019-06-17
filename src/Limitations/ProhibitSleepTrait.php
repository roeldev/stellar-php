<?php declare(strict_types=1);

namespace Stellar\Limitations;

use Stellar\Limitations\Exceptions\SerializationProhibited;

/**
 * @see:unit-test \UnitTests\Limitations\ProhibitSleepTests
 */
trait ProhibitSleepTrait
{
    /**
     * Do not allow an object to 'sleep' by serializing it.
     *
     * @see http://php.net/manual/en/language.oop5.magic.php#object.sleep
     * @throws SerializationProhibited
     */
    final public function __sleep()
    {
        throw new SerializationProhibited(static::class);
    }
}
