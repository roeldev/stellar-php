<?php declare(strict_types=1);

namespace Stellar\Encoding;

use Stellar\Common\StaticClass;
use Stellar\Support\Str;
use Stellar\Encoding\Base32\Base32Variant;
use Stellar\Encoding\Exceptions\IllegalCharacter;

/**
 * @see \UnitTests\Encoding\Base32Tests
 */
class Base32 extends StaticClass
{
    public static function encode(string $data, ?Base32Variant $variant = null, ?bool $padding = null) : string
    {
        if (Str::isEmpty($data)) {
            return '';
        }

        $variant = $variant ?? new Base32\Rfc4648();
        $alphabet = $variant->getAlphabet();

        // convert each character in the data string to it's 8 bit binary value
        $binary = unpack('C*', $data);
        foreach ($binary as $i => $char) {
            $binary[ $i ] = \sprintf('%08b', $char);
        }

        // split the 8 bit data string into 5 bit chunks
        $binary = \implode('', $binary);
        $chunks = \str_split($binary, 5);

        // make sure the last chunk also has 5 bits by adding extra 0 bits
        $chunks[] = \str_pad(\array_pop($chunks), 5, '0');

        $result = '';
        foreach ($chunks as $chunk) {
            $result .= $alphabet[ $chunk ];
        }

        return $variant->afterEncode($result, $padding);
    }

    /**
     * @throws \Stellar\Encoding\Exceptions\IllegalCharacter
     */
    public static function decode(string $data, Base32Variant $variant = null) : string
    {
        if (Str::isEmpty($data)) {
            return '';
        }

        $variant = $variant ?? new Base32\Rfc4648();
        $alphabet = \array_flip($variant->getAlphabet());

        $data = $variant->beforeDecode($data);
        $data = \rtrim($data, "=\x20\t\n\r\0\x0B");

        // recreate the complete binary string by appending
        // the 5 bit value of each encoded character
        $binary = '';
        $chars = \str_split($data);

        foreach ($chars as $i => $char) {
            if (!isset($alphabet[ $char ])) {
                throw IllegalCharacter::factory($char, $i)
                    ->withMessage($data)
                    ->withMessage(\get_class($variant))
                    ->create();
            }

            $binary .= $alphabet[ $char ];
        }

        // we know the original data is divisible by 8,
        // so remove any remaining filler 0 bits
        $binary = \substr($binary, 0, (int) \floor(\strlen($binary) / 8) * 8);
        $result = '';

        // convert the original 8 bit chunks back
        $binary = \str_split($binary, 8);
        while ($binary) {
            $result .= \chr(\bindec(\array_shift($binary)));
        }

        return $result;
    }
}
