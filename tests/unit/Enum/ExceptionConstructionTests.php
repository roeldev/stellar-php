<?php declare(strict_types=1);

namespace UnitTests\Enum;

use PHPUnit\Framework\TestCase;
use Stellar\Enum\Exceptions\ConstructionFailure;
use Stellar\Enum\Exceptions\InvalidType;
use Stellar\Enum\Exceptions\InvalidValue;
use Stellar\Enum\Exceptions\MissingConstants;
use Stellar\Exceptions\Testing\AssertExceptionConstruction;

class ExceptionConstructionTests extends TestCase
{
    use AssertExceptionConstruction;

    public function provideClasses() : array
    {
        return [
            [ ConstructionFailure::class, 'class', 'type' ],
            [ InvalidValue::class, 'class', 'value' ],
            [ MissingConstants::class, 'class' ],
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
