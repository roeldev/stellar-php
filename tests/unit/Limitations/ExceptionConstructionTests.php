<?php declare(strict_types=1);

namespace UnitTests\Limitations;

use PHPUnit\Framework\TestCase;
use Stellar\Exceptions\Testing\AssertExceptionConstruction;
use Stellar\Limitations\Exceptions\CloningProhibited;
use Stellar\Limitations\Exceptions\SerializationProhibited;
use Stellar\Limitations\Exceptions\UnserializationProhibited;

class ExceptionConstructionTests extends TestCase
{
    use AssertExceptionConstruction;

    public function provideClasses() : array
    {
        return [
            [ CloningProhibited::class, 'class' ],
            [ SerializationProhibited::class, 'class' ],
            [ UnserializationProhibited::class, 'class' ],
        ];
    }

    /**
     * @covers       \Stellar\Limitations\Exceptions\CloningProhibited::factory()
     * @covers       \Stellar\Limitations\Exceptions\SerializationProhibited::factory()
     * @covers       \Stellar\Limitations\Exceptions\UnserializationProhibited::factory()
     * @dataProvider provideClasses
     */
    public function test_exceptions(string $exceptionClass, ...$params)
    {
        $this->assertExceptionConstruction($exceptionClass, $params);
    }
}
