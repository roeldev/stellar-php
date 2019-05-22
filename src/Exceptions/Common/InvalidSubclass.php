<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Common\Stringify;
use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Logic\InvalidArgumentException;

class InvalidSubclass extends InvalidArgumentException
{
    /**
     * @param object|string $subclass
     * @param object|string $actualClass
     */
    public static function factory($subclass, $actualClass, ?string $argument = null) : ExceptionFactory
    {
        $subclass = Stringify::objectClass($subclass);
        $actualClass = Stringify::objectClass($actualClass);

        return ExceptionFactory::init(self::class)
            ->withMessage(\implode([
                'Invalid class `{actualClass}`',
                $argument ? ' for `${argument}`' : '',
                ', expected class to extend/implement/use `{subclass}`',
            ]))
            ->withArguments(\compact('subclass', 'actualClass', 'argument'));
    }
}
