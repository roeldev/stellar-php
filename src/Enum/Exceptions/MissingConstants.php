<?php declare(strict_types=1);

namespace Stellar\Enum\Exceptions;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Logic\LogicException;

final class MissingConstants extends LogicException implements EnumerableException
{
    public static function factory(string $class) : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('There are no enumerable constant types defined in class `{class}`')
            ->withArguments(\compact('class'))
            ->withSeverity(Severity::ERROR());
    }
}
