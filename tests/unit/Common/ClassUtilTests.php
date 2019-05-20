<?php declare(strict_types=1);

namespace UnitTests\Common;

use PHPUnit\Framework\TestCase;
use Stellar\Common\ClassUtil;

/**
 * @coversDefaultClass \Stellar\Common\ClassUtil
 */
class ClassUtilTests extends TestCase
{
    /**
     * @covers ::getNamespaceOf()
     */
    public function test_get_namespace_of_class()
    {
        $this->assertSame('', ClassUtil::getNamespaceOf(\ArrayObject::class));
        $this->assertSame(__NAMESPACE__, ClassUtil::getNamespaceOf(self::class));
    }

    /**
     * @covers ::getNamespaceOf()
     */
    public function test_get_namespace_of_object()
    {
        $this->assertSame('', ClassUtil::getNamespaceOf(new \ArrayObject()));
        $this->assertSame(__NAMESPACE__, ClassUtil::getNamespaceOf($this));
    }

    /**
     * @covers ::getUsedTraits()
     */
    public function test_get_used_traits()
    {
        $this->assertSame([
            ClassFixture::class          => [ DependentTraitFixture::class ],
            DependentTraitFixture::class => [ TraitFixture::class ],
            TraitFixture::class          => [],
        ], ClassUtil::getUsedTraits(ClassFixture::class));
    }

    /**
     * @covers ::exists()
     */
    public function test_exists()
    {
        $this->assertTrue(ClassUtil::exists(\ArrayObject::class));

        $this->assertFalse(ClassUtil::exists(''));
        $this->assertFalse(ClassUtil::exists('0'));
        $this->assertFalse(ClassUtil::exists(null));
        $this->assertFalse(ClassUtil::exists(ToAutoloadFixture::class, false));
        $this->assertFalse(ClassUtil::exists('\Path\To\UnexistingClass', false));
        $this->assertFalse(ClassUtil::exists('\Path\To\UnexistingClass', true));
    }
}

// -----------------------------------------------------------------------------

trait TraitFixture
{
}


trait DependentTraitFixture
{
    use TraitFixture;
}

class ClassFixture
{
    use DependentTraitFixture;
}
