<?php declare(strict_types=1);

namespace Stellar\Container\Exceptions;

use Psr\Container\NotFoundExceptionInterface;
use Stellar\Exceptions\Logic\OutOfRangeException;
use Throwable;

class NotFoundException extends OutOfRangeException implements ContainerException, NotFoundExceptionInterface
{
    public function __construct(string $id, ?Throwable $previous = null)
    {
        parent::__construct(
            'The service with id/alias `{id}` is not found',
            0,
            $previous,
            \compact('id')
        );
    }
}
