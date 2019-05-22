<?php declare(strict_types=1);

namespace Stellar\Common;

/**
 * @see:unit-test \UnitTests\Common\StringFnTests
 */
final class StringUtil extends StaticClass
{
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

        return $str === $prefix || 0 === \strpos($str, $prefix);
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

        return $str === $suffix || $suffix === \substr($str, -\strlen($suffix));
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
    public static function unprefix(string $str, string $prefix) : string
    {
        if ('' !== $str && '' !== $prefix && 0 === \strpos($str, $prefix)) {
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
    public static function unsuffix(string $str, string $suffix) : string
    {
        if ('' !== $str && '' !== $suffix) {
            $strlen = \strlen($suffix);
            if ($suffix === \substr($str, -$strlen)) {
                $str = (string) \substr($str, 0, -\strlen($suffix));
            }
        }

        return $str;
    }
}
