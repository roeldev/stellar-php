<?php declare(strict_types=1);

namespace Stellar\Limitations;

use Stellar\Limitations\Exceptions\CloningProhibited;

/**
 * @see \UnitTests\Limitations\ProhibitCloningTests
 */
trait ProhibitCloning
{
    /**
     * @see http://php.net/manual/en/language.oop5.cloning.php#object.clone
     * @throws CloningProhibited
     */
    final public function __clone()
    {
        throw CloningProhibited::factory(static::class)->create();
    }
}
