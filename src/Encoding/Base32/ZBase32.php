<?php declare(strict_types=1);

namespace Stellar\Encoding\Base32;

class ZBase32 extends AbstractBase32Variant
{
    public const ALPHABET = [
        '00000' => 'y',
        '00001' => 'b',
        '00010' => 'n',
        '00011' => 'd',
        '00100' => 'r',
        '00101' => 'f',
        '00110' => 'g',
        '00111' => '8',
        '01000' => 'e',
        '01001' => 'j',
        '01010' => 'k',
        '01011' => 'm',
        '01100' => 'c',
        '01101' => 'p',
        '01110' => 'q',
        '01111' => 'x',
        '10000' => 'o',
        '10001' => 't',
        '10010' => '1',
        '10011' => 'u',
        '10100' => 'w',
        '10101' => 'i',
        '10110' => 's',
        '10111' => 'z',
        '11000' => 'a',
        '11001' => '3',
        '11010' => '4',
        '11011' => '5',
        '11100' => 'h',
        '11101' => '7',
        '11110' => '6',
        '11111' => '9',
    ];

    public function afterEncode(string $result, ?bool $padding = null) : string
    {
        return $padding ? self::_padding($result) : $result;
    }

    public function beforeDecode(string $data) : string
    {
        return \strtolower($data);
    }
}
