<?php declare(strict_types=1);

namespace Stellar\Encoding\Base32;

class Crockford extends AbstractBase32Variant
{
    public const ALPHABET = [
        '00000' => '0',
        '00001' => '1',
        '00010' => '2',
        '00011' => '3',
        '00100' => '4',
        '00101' => '5',
        '00110' => '6',
        '00111' => '7',
        '01000' => '8',
        '01001' => '9',
        '01010' => 'A',
        '01011' => 'B',
        '01100' => 'C',
        '01101' => 'D',
        '01110' => 'E',
        '01111' => 'F',
        '10000' => 'G',
        '10001' => 'H',
        '10010' => 'J',
        '10011' => 'K',
        '10100' => 'M',
        '10101' => 'N',
        '10110' => 'P',
        '10111' => 'Q',
        '11000' => 'R',
        '11001' => 'S',
        '11010' => 'T',
        '11011' => 'V',
        '11100' => 'W',
        '11101' => 'X',
        '11110' => 'Y',
        '11111' => 'Z',
    ];

    public function beforeDecode(string $data) : string
    {
        return \str_replace([ '0', 'I', 'L' ], [ '0', '1', '1' ], \strtoupper($data));
    }
}
