<?php declare(strict_types=1);

namespace Stellar\Limitations;

use Stellar\Limitations\Exceptions\UnserializationProhibited;

/**
 * @see:unit-test \UnitTests\Limitations\ProhibitUnserializationTests
 */
trait ProhibitUnserialization
{
    /**
     * Do not allow unserialization through the Serializable interface.
     *
     * @see http://php.net/manual/en/class.serializable.php
     * @throws UnserializationProhibited
     */
    final public function unserialize(string $serialized)
    {
        throw UnserializationProhibited::factory(static::class)->create();
    }
}
