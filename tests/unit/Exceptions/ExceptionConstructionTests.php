<?php declare(strict_types=1);

namespace UnitTests\Exceptions;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Dummy;
use Stellar\Exceptions\Common\InvalidClass;
use Stellar\Exceptions\Common\InvalidSubclass;
use Stellar\Exceptions\Common\InvalidType;
use Stellar\Exceptions\Common\MissingArgument;
use Stellar\Exceptions\Common\UndeclaredClass;
use Stellar\Exceptions\Common\UndefinedClassConstant;
use Stellar\Exceptions\Common\UndefinedConstant;
use Stellar\Exceptions\Common\UnknownError;
use Stellar\Exceptions\Common\UnknownFunction;
use Stellar\Exceptions\Common\UnknownMethod;
use Stellar\Exceptions\Common\UnknownStaticMethod;
use Stellar\Exceptions\Testing\AssertExceptionConstruction;

class ExceptionConstructionTests extends TestCase
{
    use AssertExceptionConstruction;

    public function provideClasses() : array
    {
        return [
            [ InvalidClass::class, 'expectedClass', 'actualClass', 'argument' ],
            [ InvalidSubclass::class, 'expectedClass', 'actualClass', 'argument' ],
            [ InvalidType::class, 'expectedType', 'actualType', 'argument' ],
            [ MissingArgument::class, 'class', 'method' ],
            [ MissingArgument::class, 'function' ],
            [ MissingArgument::class, Dummy::closure() ],
            [ UndeclaredClass::class, 'class' ],
            [ UndefinedClassConstant::class, 'class', 'const' ],
            [ UndefinedConstant::class, 'const' ],
            [ UnknownError::class ],
            [ UnknownFunction::class, 'function' ],
            [ UnknownMethod::class, 'class', 'method' ],
            [ UnknownStaticMethod::class, 'class', 'method' ],
        ];
    }

    /**
     * @covers       \Stellar\Exceptions\Common\InvalidClass::factory()
     * @covers       \Stellar\Exceptions\Common\InvalidSubclass::factory()
     * @covers       \Stellar\Exceptions\Common\InvalidType::factory()
     * @covers       \Stellar\Exceptions\Common\MissingArgument::factory()
     * @covers       \Stellar\Exceptions\Common\UndeclaredClass::factory()
     * @covers       \Stellar\Exceptions\Common\UndefinedClassConstant::factory()
     * @covers       \Stellar\Exceptions\Common\UndefinedConstant::factory()
     * @covers       \Stellar\Exceptions\Common\UnknownError::factory()
     * @covers       \Stellar\Exceptions\Common\UnknownFunction::factory()
     * @covers       \Stellar\Exceptions\Common\UnknownMethod::factory()
     * @covers       \Stellar\Exceptions\Common\UnknownStaticMethod::factory()
     * @dataProvider provideClasses
     */
    public function test_exceptions(string $exceptionClass, ...$params)
    {
        $this->assertExceptionConstruction($exceptionClass, $params);
    }
}
