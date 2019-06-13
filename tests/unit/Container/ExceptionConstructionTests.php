<?php declare(strict_types=1);

namespace UnitTests\Container;

use PHPUnit\Framework\TestCase;
use Stellar\Container\Exceptions\BuildFailure;
use Stellar\Container\Exceptions\NotFoundException;
use Stellar\Container\Exceptions\ServiceExistsException;
use Stellar\Container\Exceptions\SingletonExistsException;
use Stellar\Exceptions\Testing\AssertExceptionConstruction;

class ExceptionConstructionTests extends TestCase
{
    use AssertExceptionConstruction;

    public function provideClasses() : array
    {
        return [
            [ NotFoundException::class, 'alias' ],
            [ ServiceExistsException::class, 'alias' ],
            [ SingletonExistsException::class, 'alias' ],
        ];
    }

    /**
     * @covers       \Stellar\Container\Exceptions\NotFoundException::__construct()
     * @covers       \Stellar\Container\Exceptions\ServiceExistsException::__construct()
     * @covers       \Stellar\Container\Exceptions\SingletonExistsException::__construct()
     * @dataProvider provideClasses
     */
    public function test_exceptions(string $exceptionClass, ...$params)
    {
        $this->assertExceptionConstruction($exceptionClass, $params);
    }
}
