<?php declare(strict_types=1);

namespace Stellar\Support;

use Stellar\Common\StaticClass;

/**
 * @see \UnitTests\Support\StringFnTests
 */
final class Str extends StaticClass
{
    /**
     * Determine whether a variable is an empty string. Unlike PHP's `empty()` function, this method
     * does not evaluate `'0'` (a zero character) as empty.
     */
    public static function isEmpty(?string ...$var) : bool
    {
        $result = true;
        foreach ($var as $arg) {
            if ('' !== $arg && null !== $arg) {
                $result = false;
                break;
            }
        }

        return $result;
    }

    public static function replaceVars(string $subject, array $vars) : string
    {
        $search = [];
        foreach ($vars as $key => $value) {
            $search[] = '{' . $key . '}';
        }

        return \str_replace($search, $vars, $subject);
    }

    public static function allBefore(string $str, string $char) : string
    {
        return '';
    }

    public static function allBeforeLast(string $str, string $char) : string
    {
        return '';
    }

    public static function allAfter(string $str, string $char) : string
    {
        return '';
    }

    public static function allAfterLast(string $str, string $char) : string
    {
        return '';
    }

    /**
     * Indicates if the string starts with the prefix. An empty string and/or empty prefix will
     * always return `false`.
     */
    public static function startsWith(string $str, string $prefix) : bool
    {
        if ('' === $str || '' === $prefix) {
            return false;
        }

        return $str === $prefix || \strpos($str, $prefix) === 0;
    }

    /**
     * Indicates if the string ends with the suffix. An empty string and/or empty suffix will always
     * return `false`.
     */
    public static function endsWith(string $str, string $suffix) : bool
    {
        if ('' === $str || '' === $suffix) {
            return false;
        }

        return $str === $suffix || \substr($str, -\strlen($suffix)) === $suffix;
    }

    /**
     * Add the prefix at the beginning of the string when it's not there.
     */
    public static function prefix(string $str, string $prefix) : string
    {
        return !self::startsWith($str, $prefix) ? $prefix . $str : $str;
    }

    /**
     * Remove the prefix at the beginning of the string when it's there.
     */
    public static function unPrefix(string $str, string $prefix) : string
    {
        if ('' !== $str && '' !== $prefix && \strpos($str, $prefix) === 0) {
            $str = (string) \substr($str, \strlen($prefix));
        }

        return $str;
    }

    /**
     * Add the suffix at the end of the string when it's not there.
     */
    public static function suffix(string $str, string $suffix) : string
    {
        return !self::endsWith($str, $suffix) ? $str . $suffix : $str;
    }

    /**
     * Remove the suffix at the end of the string when it's there.
     */
    public static function unSuffix(string $str, string $suffix) : string
    {
        if ('' !== $str && '' !== $suffix) {
            $strlen = \strlen($suffix);
            if (\substr($str, -$strlen) === $suffix) {
                $str = (string) \substr($str, 0, -\strlen($suffix));
            }
        }

        return $str;
    }
}
