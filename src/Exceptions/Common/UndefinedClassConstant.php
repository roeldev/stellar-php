<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Logic\DomainException;

/**
 * Use when an undefined constant is encountered.
 */
class UndefinedClassConstant extends DomainException
{
    public static function factory(string $class, string $const) : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('Constant `{const}` is undefined in class `{class}`')
            ->withArguments(\compact('class', 'const'));
    }
}
