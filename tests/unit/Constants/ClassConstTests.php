<?php declare(strict_types=1);

namespace UnitTests\Constants;

use PHPUnit\Framework\TestCase;
use Stellar\Constants\ClassConst;

/**
 * @coversDefaultClass \Stellar\Constants\ClassConst
 */
class ClassConstTests extends TestCase
{
    /**
     * @covers ::split()
     */
    public function test_split()
    {
        $this->assertSame([ ConstantsFixture::class, 'FOO' ], ClassConst::split(ConstantsFixture::class . '::FOO'));
        $this->assertSame([ 'Some\Class', 'BAR' ], ClassConst::split('Some\Class::BAR'));

        $this->assertNull(ClassConst::split('GLOBAL_CONST'));
    }
    /**
     * ClassConst::from('Namespace\To', 'SomeClass', 'CONST_NAME')
     * ClassConst::from('Namespace\To\SomeClass', 'CONST_NAME')
     * ClassConst::from('Namespace\To\SomeClass::CONST_NAME')
     * ClassConst::from([ 'Namespace\To', 'SomeClass', 'CONST_NAME' ])
     * ClassConst::from([ 'Namespace\To\SomeClass', 'CONST_NAME' ])
     * ClassConst::from([ 'Namespace\To\SomeClass::CONST_NAME' ])
     */
}
