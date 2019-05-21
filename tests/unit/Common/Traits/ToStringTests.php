<?php declare(strict_types=1);

namespace UnitTests\Common\Traits;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Traits\ToString;

class ToStringTests extends TestCase
{
    public function test()
    {
        $expected = 'foo bar baz';
        $this->assertSame($expected, (new ToStringFixture($expected))->toString());
        $this->assertSame($expected, (string) new ToStringFixture($expected));
    }
}

/**
 * @internal
 */
final class ToStringFixture
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
