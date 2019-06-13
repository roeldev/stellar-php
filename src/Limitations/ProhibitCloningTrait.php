<?php declare(strict_types=1);

namespace Stellar\Limitations;

use Stellar\Limitations\Exceptions\CloningProhibited;

/**
 * @see:unit-test \UnitTests\Limitations\ProhibitCloningTests
 */
trait ProhibitCloningTrait
{
    /**
     * @see http://php.net/manual/en/language.oop5.cloning.php#object.clone
     * @throws CloningProhibited
     */
    final public function __clone()
    {
        throw new CloningProhibited(static::class);
    }
}
