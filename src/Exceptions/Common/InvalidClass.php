<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Logic\InvalidArgumentException;
use Stellar\Exceptions\Support\ClassNameArgument;

class InvalidClass extends InvalidArgumentException
{
    use ClassNameArgument;

    public static function factory($expectedClass, $actualClass, ?string $argument = null) : ExceptionFactory
    {
        $expectedClass = self::_classNameArgument($expectedClass);
        $actualClass = self::_classNameArgument($actualClass);

        return ExceptionFactory::init(self::class)
            ->withMessage(\implode([
                'Invalid class `{actualClass}`',
                $argument ? ' for `${argument}`' : '',
                ', expected instance or subclass of `{expectedClass}`',
            ]))
            ->withArguments(\compact('expectedClass', 'actualClass', 'argument'));
    }
}
