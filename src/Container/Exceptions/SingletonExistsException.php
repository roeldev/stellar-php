<?php declare(strict_types=1);

namespace Stellar\Container\Exceptions;

use Stellar\Exceptions\Runtime\RuntimeException;
use Throwable;

class SingletonExistsException extends RuntimeException implements ContainerException
{
    public function __construct(string $id, ?Throwable $previous = null)
    {
        parent::__construct(
            'A singleton service with id `{id}` already exists.',
            0,
            $previous,
            \compact('id')
        );
    }
}
