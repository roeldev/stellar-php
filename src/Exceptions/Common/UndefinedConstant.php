<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Logic\LogicException;

/**
 * Use when an undefined constant is encountered.
 */
class UndefinedConstant extends LogicException
{
    public static function factory(string $const) : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('Undefined constant `{const}`')
            ->withArguments(\compact('const'));
    }
}
