<?php declare(strict_types=1);

namespace UnitTests\Support;

use PHPUnit\Framework\TestCase;
use Stellar\Support\Cls;

/**
 * @coversDefaultClass \Stellar\Support\Cls
 */
class ClassFnTests extends TestCase
{
    /**
     * @covers ::isAnonymous()
     */
    public function test_is_invalid_anonymous_class()
    {
        $this->assertFalse(Cls::isAnonymous('\Path\To\UnexistingClass'));
    }

    /**
     * @covers ::namespaceOf()
     */
    public function test_getNamespace()
    {
        $this->assertSame('', Cls::namespaceOf(\ArrayObject::class));
        $this->assertSame(__NAMESPACE__, Cls::namespaceOf(self::class));
    }

    public function test_getUsedTraits()
    {
        $this->assertSame([
            ClassFixture::class          => [ DependentTraitFixture::class ],
            DependentTraitFixture::class => [ TraitFixture::class ],
            TraitFixture::class          => [],
        ], Cls::getUsedTraits(ClassFixture::class));
    }

    /**
     * @covers ::exists()
     */
    public function test_can_construct()
    {
        $this->assertTrue(Cls::exists(\ArrayObject::class));

        $this->assertFalse(Cls::exists(''));
        $this->assertFalse(Cls::exists('0'));
        $this->assertFalse(Cls::exists(null));
        $this->assertFalse(Cls::exists(ToAutoloadFixture::class, false));
        $this->assertFalse(Cls::exists('\Path\To\UnexistingClass', false));
        $this->assertFalse(Cls::exists('\Path\To\UnexistingClass', true));
    }
}
