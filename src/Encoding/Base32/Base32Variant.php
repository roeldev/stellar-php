<?php declare(strict_types=1);

namespace Stellar\Encoding\Base32;

interface Base32Variant
{
    public function getAlphabet() : array;

    public function afterEncode(string $result, ?bool $padding = null) : string;

    public function beforeDecode(string $data) : string;
}
