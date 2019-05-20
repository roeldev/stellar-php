<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Common\Stringify;
use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Logic\BadMethodCallException;

/**
 * Use when a call to `__call()` is invalid.
 */
class UnknownMethod extends BadMethodCallException
{
    /**
     * @param string|object $class
     * @param string        $method
     * @return ExceptionFactory
     */
    public static function factory($class, string $method) : ExceptionFactory
    {
        $class = Stringify::objectClass($class);

        return ExceptionFactory::init(self::class)
            ->withMessage('Method `{method}` does not exist in class `{class}`')
            ->withArguments(\compact('class', 'method'))
            ->withSeverity(Severity::ERROR());
    }
}
