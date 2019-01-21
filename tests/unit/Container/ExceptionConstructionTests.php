<?php declare(strict_types=1);

namespace UnitTests\Container;

use PHPUnit\Framework\TestCase;
use Stellar\Container\Exceptions\BuildFailure;
use Stellar\Container\Exceptions\NotFound;
use Stellar\Container\Exceptions\ServiceAlreadyExists;
use Stellar\Container\Exceptions\SingletonAlreadyExists;
use Stellar\Exceptions\Testing\AssertExceptionConstruction;

class ExceptionConstructionTests extends TestCase
{
    use AssertExceptionConstruction;

    public function provideClasses() : array
    {
        return [
            [ NotFound::class, 'alias' ],
            [ ServiceAlreadyExists::class, 'alias' ],
            [ SingletonAlreadyExists::class, 'alias' ],
        ];
    }

    /**
     * @covers       \Stellar\Container\Exceptions\NotFound::factory()
     * @covers       \Stellar\Container\Exceptions\ServiceAlreadyExists::factory()
     * @covers       \Stellar\Container\Exceptions\SingletonAlreadyExists::factory()
     * @dataProvider provideClasses
     */
    public function test_exceptions(string $exceptionClass, ...$params)
    {
        $this->assertExceptionConstruction($exceptionClass, $params);
    }
}
