<?php declare(strict_types=1);

namespace Stellar\Enum\Exceptions;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Logic\LogicException;

final class InvalidValue extends LogicException implements EnumerableException
{
    public static function factory(string $class, $value) : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('A value of `{value}` does not exist in class `{class}`')
            ->withArguments(\compact('class', 'value'))
            ->withSeverity(Severity::WARNING());
    }
}
