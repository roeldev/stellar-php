<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Logic\LogicException;

/**
 * Use when an undeclared class is encountered.
 */
class UndeclaredClass extends LogicException
{
    public static function factory(string $class) : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('Class `{class}` does not exist')
            ->withArguments(\compact('class'));
    }
}
