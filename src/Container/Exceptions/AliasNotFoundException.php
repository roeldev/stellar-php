<?php declare(strict_types=1);

namespace Stellar\Container\Exceptions;

use Psr\Container\NotFoundExceptionInterface;
use Stellar\Exceptions\Logic\OutOfRangeException;
use Throwable;

class AliasNotFoundException extends OutOfRangeException implements ContainerException, NotFoundExceptionInterface
{
    public function __construct(string $id, string $group, ?Throwable $previous = null)
    {
        parent::__construct(
            'The service with alias `{id}` within group `{group}` is not found',
            0,
            $previous,
            \compact('id', 'group')
        );
    }
}
