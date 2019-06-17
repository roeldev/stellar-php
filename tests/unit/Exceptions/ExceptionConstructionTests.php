<?php declare(strict_types=1);

namespace UnitTests\Exceptions;

use PHPUnit\Framework\TestCase;
use Stellar\Exceptions\Common\InvalidArgument;
use Stellar\Exceptions\Common\InvalidClass;
use Stellar\Exceptions\Common\InvalidType;
use Stellar\Exceptions\Common\MissingArgument;
use Stellar\Exceptions\Common\UndeclaredClass;
use Stellar\Exceptions\Common\UndefinedConstant;
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
            [ InvalidArgument::class, 'argument', 'expected', 'actual' ],
            [ InvalidClass::class, 'expected', 'actual' ],
            [ InvalidType::class, 'expected', 'actual' ],
            [ MissingArgument::class, 'method', 'class' ],
            [ UndeclaredClass::class, 'class' ],
            [ UndefinedConstant::class, 'const', 'class' ],
            [ UnknownFunction::class, 'function' ],
            [ UnknownMethod::class, 'class', 'method' ],
            [ UnknownStaticMethod::class, 'class', 'method' ],
        ];
    }

    /**
     * @covers       \Stellar\Exceptions\Common\InvalidArgument::__construct()
     * @covers       \Stellar\Exceptions\Common\InvalidClass::__construct()
     * @covers       \Stellar\Exceptions\Common\InvalidType::__construct()
     * @covers       \Stellar\Exceptions\Common\MissingArgument::__construct()
     * @covers       \Stellar\Exceptions\Common\UndeclaredClass::__construct()
     * @covers       \Stellar\Exceptions\Common\UndefinedConstant::__construct()
     * @covers       \Stellar\Exceptions\Common\UnknownFunction::__construct()
     * @covers       \Stellar\Exceptions\Common\UnknownMethod::__construct()
     * @covers       \Stellar\Exceptions\Common\UnknownStaticMethod::__construct()
     * @dataProvider provideClasses
     */
    public function test_exceptions(string $exceptionClass, ...$params)
    {
        $this->assertExceptionConstruction($exceptionClass, $params);
    }
}
