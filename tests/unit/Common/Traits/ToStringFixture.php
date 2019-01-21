<?php declare(strict_types=1);

namespace UnitTests\Common\Traits;

use Stellar\Common\Traits\ToString;

class ToStringFixture
{
    use ToString;

    /** @var string */
    protected $_testString;

    public function __construct(?string $testString = null)
    {
        $this->_testString = $testString ?: self::class;
    }

    public function __toString() : string
    {
        return $this->_testString;
    }
}
