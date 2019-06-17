<?php declare(strict_types=1);

namespace UnitTests\Common\Abilities;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Abilities\StringableTrait;

class StringableTraitTests extends TestCase
{
    public function test()
    {
        $expected = 'foo bar baz';
        $this->assertSame($expected, (new StringableTraitFixture($expected))->toString());
        $this->assertSame($expected, (string) new StringableTraitFixture($expected));
    }
}

/**
 * @internal
 */
final class StringableTraitFixture
{
    use StringableTrait;

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
