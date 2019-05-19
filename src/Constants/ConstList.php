<?php declare(strict_types=1);

namespace Stellar\Constants;

use Stellar\Common\Types\StaticClass;

/**
 * @see \UnitTests\Constants\ConstListTests
 */
class ConstList extends StaticClass
{
    public static function fromCategory(string $category) : array
    {
        $definedConstants = \get_defined_constants(true);
        $result = $definedConstants[ $category ] ?? null;

        if (null === $result) {
            $category = \strtolower($category);

            $result = $definedConstants[ $category ] ??
                      $definedConstants[ \ucfirst($category) ] ??
                      [];
        }

        return $result ?? [];
    }

    public static function startingWith(string $prefix, ?string $category = null) : array
    {
        $definedConstants = null === $category ?
            \get_defined_constants() :
            self::fromCategory($category);

        $result = [];
        foreach ($definedConstants as $name => $value) {
            if (0 === \strpos($name, $prefix)) {
                $result[ $name ] = $value;
            }
        }

        return $result;
    }
}
