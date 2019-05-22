<?php declare(strict_types=1);

namespace Stellar\Constants;

use Stellar\Common\StaticClass;
use Stellar\Common\StringUtil;

/**
 * @see:unit-test \UnitTests\Constants\ConstUtilTests
 */
class ConstUtil extends StaticClass
{
    public static function getList(string $category) : array
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

    public static function split(string $classConst) : ?array
    {
        $result = null;
        if ($classConst) {
            $classConst = StringUtil::unprefix($classConst, '\\');
            if (\strlen($classConst) >= 4 && false !== \strpos($classConst, '::', 1)) {
                $result = \explode('::', $classConst, 2);
            }
        }

        return $result;
    }
}
