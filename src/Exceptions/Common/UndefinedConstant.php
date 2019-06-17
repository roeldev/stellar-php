<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Exceptions\Logic\LogicException;
use Throwable;

/**
 * Use when an undefined constant is encountered.
 */
class UndefinedConstant extends LogicException
{
    public function __construct(string $const, ?string $class = null, ?Throwable $previous = null)
    {
        parent::__construct(
            (null === $class)
                ? 'Undefined constant `{const}`'
                : 'Undefined constant `{const}` in class `{class}`',
            0,
            $previous,
            \compact('const', 'class')
        );
    }
}
