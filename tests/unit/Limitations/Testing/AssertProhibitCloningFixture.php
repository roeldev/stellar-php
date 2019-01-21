<?php declare(strict_types=1);

namespace UnitTests\Limitations\Testing;

use Stellar\Common\Testing\CaptureMethodCalls;
use Stellar\Exceptions\ExceptionType;
use Stellar\Limitations\Testing\AssertProhibitCloning;

/**
 * @property-read string        $expectException
 * @property-read ExceptionType $expectExceptionType
 */
class AssertProhibitCloningFixture
{
    use AssertProhibitCloning;
    use CaptureMethodCalls;
}
