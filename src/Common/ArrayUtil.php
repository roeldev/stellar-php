<?php declare(strict_types=1);

namespace Stellar\Common;

/**
 * @see \UnitTests\Common\ArrayUtilTests
 */
final class ArrayUtil extends StaticClass
{
    public static function merge(iterable ...$arrays) : array
    {
        if (1 === \count($arrays)) {
            return Arrayify::any($arrays[0]);
        }

        $result = [];
        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                $result[ $key ] = $value;
            }
        }

        return $result;
    }

    /**
     * Joins the keys of an array with their values.
     *
     * @param string $glue
     * @param iterable<string,string> $iterator
     * @return array
     */
    public static function join(string $glue, iterable $iterator, bool $exclEmpty = true) : array
    {
        $result = [];
        foreach ($iterator as $key => $value) {
            $value = Stringify::any($value);
            if (!Assert::isEmptyString((string) $key, $value)) {
                $result[ $key ] = $key . $glue . $value;
            }
            elseif (!$exclEmpty) {
                $result[ $key ] = '';
            }
        }

        return $result;
    }

    /**
     * Joins the keys, indexes and or values of an array entry according to the specified format.
     *
     * %k - the key
     * %i - the offset position
     * %v - the value
     */
    public static function joinFormat(string $format, iterable $iterator, bool $exclEmpty = true) : array
    {
        $formatHasKey = (false !== \strpos($format, '%k'));
        $formatHasIndex = (false !== \strpos($format, '%i'));
        $formatHasValue = (false !== \strpos($format, '%v'));

        if (!$formatHasKey && !$formatHasIndex && !$formatHasValue) {
            return Arrayify::iterable($iterator);
        }

        $search = [ '%k', '%i', '%v' ];
        $indexes = [];

        if ($formatHasIndex) {
            $indexes = \array_keys(Arrayify::any($iterator));
            $indexes = \array_flip($indexes);
        }

        $result = [];
        foreach ($iterator as $key => $value) {
            $value = Stringify::any($value);
            if (!Assert::isEmptyString((string) $key, $value)) {
                $replace = [ $key, $indexes[ $key ] ?? '', $value ];
                $result[ $key ] = \str_replace($search, $replace, $format);
            }
            elseif (!$exclEmpty) {
                $result[ $key ] = '';
            }
        }

        return $result;
    }

    public static function flatten(array $array, ?int $depth = null)
    {
        if (0 === $depth) {
            return \array_values($array);
        }

        $merge = [ [] ];
        $end = 0;

        if (null !== $depth) {
            --$depth;
        }

        foreach ($array as $value) {
            if (!\is_array($value)) {
                $merge[ $end ][] = $value;
                continue;
            }

            $merge[] = self::flatten($value, $depth);
            $end++;
        }

        return \array_merge(...$merge);
    }

    public static function flattenKeys(array $array, string $glue = '.', ?int $depth = null, string $prefix = '')
    {
        if ('' !== $prefix && !StringUtil::endsWith($prefix, $glue)) {
            $prefix .= $glue;
        }

        $merge = [];
        $end = 0;

        $hasDepthLimit = (null !== $depth);
        $depthReached = ($hasDepthLimit && 0 === $depth);

        if ($hasDepthLimit) {
            --$depth;
        }

        foreach ($array as $key => $value) {
            $key = $prefix . $key;

            if (!\is_array($value) || $depthReached) {
                $merge[ $end ][ $key ] = $value;
                continue;
            }

            $merge[] = self::flattenKeys($value, $glue, $depth, $key);
            $end++;
        }

        return \array_merge(...$merge);
    }

    /**
     * Return the array with only the specified keys.
     */
    public static function withKeys(array $array, string ...$keys) : array
    {
        return !empty($array) && !empty($keys)
            ? \array_intersect_key($array, \array_flip($keys))
            : [];
    }

    /**
     * Return the array without the specified keys.
     */
    public static function withoutKeys(array $array, string ...$keys) : array
    {
        $result = [];
        if (empty($keys)) {
            $result = $array;
        }
        elseif (!empty($array)) {
            $result = \array_diff_key($array, \array_flip($keys));
        }

        return $result;
    }

    // todo: WIP
    // public static function limitDepth(array $array, int $depth) : array
    // {
    //     return $array;
    // }

    /**
     * Wrap a non-array variable in an array.
     *
     * @param mixed $var
     */
    public static function wrap($var) : array
    {
        if (!\is_array($var)) {
            $var = [ $var ];
        }

        return $var;
    }

    /**
     * Unwrap a single value from an array.
     *
     * @param mixed $var
     * @return mixed
     */
    public static function unwrap($var)
    {
        if (\is_array($var) && 1 === \count($var)) {
            $var = \reset($var);
        }

        return $var;
    }
}
