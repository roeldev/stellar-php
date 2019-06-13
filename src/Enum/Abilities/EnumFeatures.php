<?php declare(strict_types=1);

namespace Stellar\Enum\Abilities;

use Stellar\Enum\EnumerablesList;
use Stellar\Limitations\ProhibitCloningTrait;

trait EnumFeatures
{
    use ProhibitCloningTrait;

    public static function enum() : EnumerablesList
    {
        return EnumerablesList::instance(static::class);
    }

    public static function list() : array
    {
        return static::enum()->getList();
    }

    final public static function constOf($value) : ?string
    {
        return static::enum()->constOf($value);
    }

    final public static function nameOf($type) : ?string
    {
        return static::enum()->nameOf($type);
    }

    final public static function valueOf($type)
    {
        return static::enum()->valueOf($type);
    }
}
