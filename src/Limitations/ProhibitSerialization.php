<?php declare(strict_types=1);

namespace Stellar\Limitations;

use Stellar\Limitations\Exceptions\SerializationProhibited;

/**
 * @see:unit-test \UnitTests\Limitations\ProhibitSerializationTests
 */
trait ProhibitSerialization
{
    /**
     * Do not allow serialization through the Serializable interface.
     *
     * @see http://php.net/manual/en/class.serializable.php
     * @throws SerializationProhibited
     */
    final public function serialize()
    {
        throw SerializationProhibited::factory(static::class)->create();
    }
}
