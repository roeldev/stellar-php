<?php declare(strict_types=1);

namespace Stellar\Container\Exceptions;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Runtime\RuntimeException;

final class AliasAlreadyExists extends RuntimeException implements ContainerException
{
    public static function factory(string $alias, string $id) : ExceptionFactory
    {
        return ExceptionFactory::init(static::class)
            ->withMessage('Alias `{alias}` already exists for a service with id `{id}`.')
            ->withArguments(\compact('alias', 'id'))
            ->withSeverity(Severity::WARNING());
    }
}
