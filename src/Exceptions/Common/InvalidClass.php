<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Common\Stringify;
use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Logic\InvalidArgumentException;

/**
 * @method InvalidClass create($expectedClass, $actualClass, ?string $argument = null)
 */
class InvalidClass extends InvalidArgumentException
{
    /**
     * @param object|string $expectedClass
     * @param object|string $actualClass
     */
    public static function factory($expectedClass, $actualClass, ?string $argument = null) : ExceptionFactory
    {
        $expectedClass = Stringify::objectClass($expectedClass);
        $actualClass = Stringify::objectClass($actualClass);

        return ExceptionFactory::init(self::class)
            ->withMessage(\implode([
                'Invalid class `{actualClass}`',
                $argument ? ' for `${argument}`' : '',
                ', expected instance or implementation of `{expectedClass}`',
            ]))
            ->withArguments(\compact('expectedClass', 'actualClass', 'argument'));
    }
}
