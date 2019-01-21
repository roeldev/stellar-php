<?php declare(strict_types=1);

namespace UnitTests\Limitations\Testing;

use Stellar\Common\Testing\CaptureMethodCalls;
use Stellar\Exceptions\ExceptionType;
use Stellar\Limitations\Testing\AssertProhibitSerialization;

/**
 * @property-read string        $expectException
 * @property-read ExceptionType $expectExceptionType
 */
class AssertProhibitSerializationFixture
{
    use AssertProhibitSerialization;
    use CaptureMethodCalls;
}
