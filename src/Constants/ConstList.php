<?php declare(strict_types=1);

namespace Stellar\Constants;

use Stellar\Common\StaticClass;

/**
 * @see \UnitTests\Constants\ConstListTests
 */
class ConstList extends StaticClass
{
    public static function startingWith(string $prefix, ?string $category = null) : array
    {
        $definedConstants = (null === $category)
            ? \get_defined_constants()
            : ConstUtil::getList($category);

        $result = [];
        foreach ($definedConstants as $name => $value) {
            if (0 === \strpos($name, $prefix)) {
                $result[ $name ] = $value;
            }
        }

        return $result;
    }
}
