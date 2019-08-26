<?php declare(strict_types=1);

namespace Stellar\Encoding\Base32;

/**
 * @link https://tools.ietf.org/html/rfc4648
 */
abstract class AbstractBase32Variant implements Base32Variant
{
    public const ALPHABET = [];

    protected static function _padding(string $result) : string
    {
        return \str_pad($result, (int) \ceil(\strlen($result) / 8) * 8, '=');
    }

    final public function getAlphabet() : array
    {
        return static::ALPHABET;
    }

    // make sure the result is divisible by 8 by adding sufficient padding
    public function afterEncode(string $result, ?bool $padding = null) : string
    {
        return (false !== $padding) ? self::_padding($result) : $result;
    }

    public function beforeDecode(string $data) : string
    {
        return \strtoupper($data);
    }
}
