<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Common\StringUtil;
use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Logic\InvalidArgumentException;

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
        $expectedType = StringUtil::unprefix($expectedType, '`');
        $expectedType = StringUtil::unsuffix($expectedType, '`');

        return ExceptionFactory::init(self::class)
            ->withMessage(\implode([
                'Invalid type `{actualType}`',
                $argument ? ' for `${argument}`' : '',
                ', expecting `{expectedType}`',
            ]))
            ->withArguments(\compact('expectedType', 'actualType', 'argument'));
    }
}
