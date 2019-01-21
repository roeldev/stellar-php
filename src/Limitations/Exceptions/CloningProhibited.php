<?php declare(strict_types=1);

namespace Stellar\Limitations\Exceptions;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Logic\BadMethodCallException;

/**
 * Use when a call to `__clone()` is not allowed.
 */
final class CloningProhibited extends BadMethodCallException implements LimitationException
{
    public static function factory(string $class) : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('Cloning of `{class}` is not allowed')
            ->withArguments(\compact('class'))
            ->withSeverity(Severity::ERROR());
    }
}
