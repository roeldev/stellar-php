<?php declare(strict_types=1);

namespace UnitTests\Factory;

use PHPUnit\Framework\TestCase;
use Stellar\Exceptions\Testing\AssertExceptionConstruction;
use Stellar\Factory\Exceptions\CreationException;

class ExceptionConstructionTests extends TestCase
{
    use AssertExceptionConstruction;

    public function provideClasses() : array
    {
        return [
            [ CreationException::class, 'class' ],
        ];
    }

    /**
     * @dataProvider provideClasses
     */
    public function test_exceptions(string $exceptionClass, ...$params)
    {
        $this->assertExceptionConstruction($exceptionClass, $params);
    }
}
