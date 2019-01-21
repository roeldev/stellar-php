<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Logic\BadMethodCallException;

/**
 * Use when a call to `__callStatic()` is invalid.
 */
class UnknownStaticMethod extends BadMethodCallException
{
    public static function factory(string $class, string $method) : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('Static method `{method}` does not exist for class `{class}`')
            ->withArguments(\compact('class', 'method'))
            ->withSeverity(Severity::ERROR());
    }
}
