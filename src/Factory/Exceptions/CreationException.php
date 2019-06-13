<?php declare(strict_types=1);

namespace Stellar\Factory\Exceptions;

use Stellar\Exceptions\Runtime\RuntimeException;
use Throwable;

final class CreationException extends RuntimeException implements FactoryException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct(
            'Failed to create a new object of `{class}`',
            0,
            $previous,
            \compact('class')
        );
    }
}
