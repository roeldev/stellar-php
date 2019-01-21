<?php declare(strict_types=1);

namespace Stellar\Enum\Exceptions;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Runtime\RuntimeException;

final class ConstructionFailure extends RuntimeException implements EnumerableException
{
    public static function factory(string $class, string $type) : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('Class `{class}` is unable to construct an Enum instance for type `{type}`')
            ->withArguments(\compact('class', 'type'))
            ->withSeverity(Severity::ERROR());
    }
}
