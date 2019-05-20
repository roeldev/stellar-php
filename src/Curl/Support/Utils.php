<?php declare(strict_types=1);

namespace Stellar\Curl\Support;

use Stellar\Common\StaticClass;
use Stellar\Curl\Curl;
use Stellar\Common\Arr;

final class Utils extends StaticClass
{
    protected const MERGE_JOIN_OPTIONS = [
        \CURLOPT_HTTPHEADER,
        \CURLOPT_POSTFIELDS,
    ];

    public static function isValidInt($option) : bool
    {
        return \is_int($option) && \in_array($option, Curl::optionConstants(), true);
    }

    public static function isValidStr($option) : bool
    {
        return \is_string($option) && \array_key_exists($option, Curl::optionConstants());
    }

    /**
     * @param array<int,mixed> $options
     * @return array<string,mixed>
     */
    public static function constantNamesKeys(array $options) : array
    {
        $constants = \array_flip(Curl::optionConstants());

        $result = [];
        foreach ($options as $option => $value) {
            if (\array_key_exists($option, $constants)) {
                $result[ '\\' . $constants[ $option ] ] = $value;
            }
        }

        return $result;
    }

    public static function filter(array $options) : array
    {
        $result = [];
        foreach ($options as $option => $value) {
            if (self::isValidStr($option)) {
                $option = \constant($option);
            }
            elseif (!self::isValidInt($option)) {
                continue;
            }

            $result[ $option ] = $value;
        }

        return $result;
    }

    public static function merge(array $target, array $merge) : array
    {
        foreach (self::MERGE_JOIN_OPTIONS as $option) {
            if (isset($merge[ $option ])) {
                $target[ $option ] = Arr::merge($target[ $option ] ?? [], $merge[ $option ]);
                unset($merge[ $option ]);
            }
        }

        return Arr::merge($target, $merge);
    }

    public static function parseUrl(string $option) : array
    {
        return [];
    }

    /**
     * @param string[] $headers
     * @return array<string,string>
     */
    public static function parseHeaders(array $headers) : array
    {
        return [];
    }
}
