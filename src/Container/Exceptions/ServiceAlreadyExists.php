<?php declare(strict_types=1);

namespace Stellar\Container\Exceptions;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Runtime\RuntimeException;

final class ServiceAlreadyExists extends RuntimeException implements ContainerException
{
    public static function factory(string $id) : ExceptionFactory
    {
        return ExceptionFactory::init(static::class)
            ->withMessage('A service with id `{id}` already exists.')
            ->withArguments(\compact('id'))
            ->withSeverity(Severity::WARNING());
    }
}
