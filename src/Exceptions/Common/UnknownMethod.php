<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Logic\BadMethodCallException;
use Stellar\Exceptions\Support\ClassNameArgument;

/**
 * Use when a call to `__call()` is invalid.
 */
class UnknownMethod extends BadMethodCallException
{
    use ClassNameArgument;

    /**
     * @param string|object $class
     * @param string        $method
     * @return ExceptionFactory
     */
    public static function factory($class, string $method) : ExceptionFactory
    {
        $class = static::_classNameArgument($class);

        return ExceptionFactory::init(self::class)
            ->withMessage('Method `{method}` does not exist for class `{class}`')
            ->withArguments(\compact('class', 'method'))
            ->withSeverity(Severity::ERROR());
    }
}
