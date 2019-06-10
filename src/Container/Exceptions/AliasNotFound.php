<?php declare(strict_types=1);

namespace Stellar\Container\Exceptions;

use Psr\Container\NotFoundExceptionInterface;
use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Logic\OutOfRangeException;

final class AliasNotFound extends OutOfRangeException implements ContainerException, NotFoundExceptionInterface
{
    public static function factory(string $alias) : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('The service with alias `{alias}` is not found')
            ->withArguments(\compact('alias'))
            ->withSeverity(Severity::WARNING());
    }
}
