<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Exceptions\Logic\LogicException;
use Throwable;

/**
 * Use when an undeclared class is encountered.
 */
class UndeclaredClass extends LogicException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct(
            'Class `{class}` does not exist',
            0,
            $previous,
            \compact('class')
        );
    }
}
