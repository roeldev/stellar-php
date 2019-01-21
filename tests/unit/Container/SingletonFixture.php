<?php declare(strict_types=1);

namespace UnitTests\Container;

use Stellar\Common\Contracts\SingletonInterface;
use Stellar\Common\Contracts\StringableInterface;
use Stellar\Common\Traits\ToString;
use Stellar\Container\Registry;
use Stellar\Limitations\ProhibitCloning;
use Stellar\Limitations\ProhibitUnserialization;
use Stellar\Limitations\ProhibitWakeup;

class SingletonFixture implements SingletonInterface, StringableInterface
{
    use ProhibitCloning;
    use ProhibitUnserialization;
    use ProhibitWakeup;
    use ToString;

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
