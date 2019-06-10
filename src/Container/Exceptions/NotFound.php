<?php declare(strict_types=1);

namespace Stellar\Container\Exceptions;

use Psr\Container\NotFoundExceptionInterface;
use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Logic\OutOfRangeException;

final class NotFound extends OutOfRangeException implements ContainerException, NotFoundExceptionInterface
{
    public static function factory(string $id) : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('The service with id or alias `{id}` is not found')
            ->withArguments(\compact('id'))
            ->withSeverity(Severity::WARNING());
    }
}
