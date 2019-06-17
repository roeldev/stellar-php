<?php declare(strict_types=1);

namespace UnitTests\Container;

use Stellar\Common\Contracts\SingletonInterface;
use Stellar\Common\Contracts\StringableInterface;
use Stellar\Common\Abilities\StringableTrait;
use Stellar\Container\Registry;
use Stellar\Limitations\ProhibitCloningTrait;
use Stellar\Limitations\ProhibitUnserializationTrait;
use Stellar\Limitations\ProhibitWakeupTrait;

class SingletonFixture implements SingletonInterface, StringableInterface
{
    use ProhibitCloningTrait;
    use ProhibitUnserializationTrait;
    use ProhibitWakeupTrait;
    use StringableTrait;

    public static function instance() : self
    {
        return Registry::singleton(static::class);
    }

    public $foo = 0;

    public function __toString() : string
    {
        return static::class;
    }
}
