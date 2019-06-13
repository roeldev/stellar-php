<?php declare(strict_types=1);

namespace UnitTests\Factory;

use PHPUnit\Framework\TestCase;
use Stellar\Factory\Exceptions\CreationException;
use Stellar\Factory\Factory;

/**
 * @coversDefaultClass \Stellar\Factory\Factory
 */
class FactoryTests extends TestCase
{
    /**
     * @covers ::create()
     */
    public function test_create_native_class_with_params()
    {
        /** @var \ArrayObject $target */
        $input = [ 1, 2, 3 ];
        $target = Factory::create(\ArrayObject::class, [ $input ], false);

        $this->assertInstanceOf(\ArrayObject::class, $target);
        $this->assertSame($input, $target->getArrayCopy());
    }

    /**
     * @covers ::create()
     */
    public function test_create_with_autoload()
    {
        $this->assertFalse(\class_exists(ToAutoloadFixture::class, false));
        $this->assertInstanceOf(ToAutoloadFixture::class, Factory::create(ToAutoloadFixture::class));
    }

    /**
     * @covers ::create()
     */
    public function test_create_without_autoload()
    {
        $this->assertFalse(\class_exists(NotToAutoloadFixture::class, false));
        $this->expectException(CreationException::class);

        Factory::create(NotToAutoloadFixture::class, [], false);
    }

    /**
     * @covers ::create()
     */
    public function test_cannot_create_empty_string()
    {
        $this->expectException(CreationException::class);
        Factory::create('');
    }

    /**
     * @covers ::create()
     */
    public function test_cannot_create_unknown_class()
    {
        $this->expectException(CreationException::class);
        Factory::create('\Path\To\UnexistingClass');
    }
}
