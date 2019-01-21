<?php declare(strict_types=1);

namespace UnitTests\Factory;

use PHPUnit\Framework\TestCase;
use Stellar\Factory\Exceptions\ConstructionFailure;
use Stellar\Factory\Factory;

/**
 * @coversDefaultClass \Stellar\Factory\Factory
 */
class FactoryTests extends TestCase
{
    /**
     * @covers ::construct()
     */
    public function test_construct_native_class_with_params()
    {
        /** @var \ArrayObject $target */
        $input = [ 1, 2, 3 ];
        $target = Factory::construct(\ArrayObject::class, [ $input ], false);

        $this->assertInstanceOf(\ArrayObject::class, $target);
        $this->assertSame($input, $target->getArrayCopy());
    }

    /**
     * @covers ::construct()
     */
    public function test_construct_with_autoload()
    {
        $this->assertFalse(\class_exists(ToAutoloadFixture::class, false));
        $this->assertInstanceOf(ToAutoloadFixture::class, Factory::construct(ToAutoloadFixture::class));
    }

    /**
     * @covers ::construct()
     */
    public function test_construct_without_autoload()
    {
        $this->assertFalse(\class_exists(NotToAutoloadFixture::class, false));
        $this->expectException(ConstructionFailure::class);

        Factory::construct(NotToAutoloadFixture::class, [], false);
    }

    /**
     * @covers ::construct()
     */
    public function test_cannot_construct_empty_string()
    {
        $this->expectException(ConstructionFailure::class);
        Factory::construct('');
    }

    /**
     * @covers ::construct()
     */
    public function test_cannot_construct_unknown_class()
    {
        $this->expectException(ConstructionFailure::class);
        Factory::construct('\Path\To\UnexistingClass');
    }
}
