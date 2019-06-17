<?php declare(strict_types=1);

namespace Stellar\Container\Exceptions;

use Stellar\Exceptions\Runtime\RuntimeException;
use Throwable;

class AliasExistsException extends RuntimeException implements ContainerException
{
    public function __construct(string $alias, string $id, ?Throwable $previous = null)
    {
        parent::__construct(
            'The alias `{alias}` already exists for a service with id `{id}`',
            0,
            $previous,
            \compact('alias', 'id')
        );
    }
}
