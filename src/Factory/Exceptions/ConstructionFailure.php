<?php declare(strict_types=1);

namespace Stellar\Factory\Exceptions;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Runtime\RuntimeException;

final class ConstructionFailure extends RuntimeException implements FactoryException
{
    public static function factory(string $class) : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('Failed to construct a new object of `{class}`')
            ->withArguments(\compact('class'))
            ->withSeverity(Severity::WARNING());
    }
}
