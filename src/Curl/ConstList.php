<?php declare(strict_types=1);

namespace Stellar\Curl;

use Stellar\Common\StaticClass;
use Stellar\Constants\ConstList as CL;

class ConstList extends StaticClass
{
    /** @var array<string,array> */
    private static $_constList = [];

    private static function _constList(string $prefix, array $add = []) : array
    {
        if (!\array_key_exists($prefix, self::$_constList)) {
            $list = CL::startingWith($prefix, 'curl');
            foreach ($add as $constant) {
                $list[ $constant ] = \constant($constant);
            }

            self::$_constList[ $prefix ] = $list;
        }

        return self::$_constList[ $prefix ];
    }

    public static function errorConstants() : array
    {
        return self::_constList('CURLE_');
    }

    public static function infoConstants() : array
    {
        return self::_constList('CURLINFO_');
    }

    public static function multiConstants() : array
    {
        return self::_constList('CURLM_');
    }

    public static function optionConstants() : array
    {
        return self::_constList('CURLOPT_', [ 'CURLINFO_HEADER_OUT' ]);
    }

    public static function proxyTypeConstants() : array
    {
        return self::_constList('CURLPROXY_');
    }
}
