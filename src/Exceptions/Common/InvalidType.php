<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Logic\InvalidArgumentException;
use Stellar\Support\Str;

/**
 * Use when an unexpected variable type is encountered.
 */
class InvalidType extends InvalidArgumentException
{
    public static function factory(
        string $expectedType,
        string $actualType,
        ?string $argument = null) : ExceptionFactory
    {
        $expectedType = Str::unPrefix($expectedType, '`');
        $expectedType = Str::unSuffix($expectedType, '`');

        return ExceptionFactory::init(self::class)
            ->withMessage(\implode([
                'Invalid type `{actualType}`',
                $argument ? ' for `${argument}`' : '',
                ', expecting `{expectedType}`',
            ]))
            ->withArguments(\compact('expectedType', 'actualType', 'argument'));
    }
}
