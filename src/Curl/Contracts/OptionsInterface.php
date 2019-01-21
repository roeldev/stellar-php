<?php declare(strict_types=1);

namespace Stellar\Curl\Contracts;

use Stellar\Common\Contracts\ArrayableInterface;

interface OptionsInterface extends OptionableInterface, ArrayableInterface
{
    /**
     * Get the array representation of the CURL options and their values.
     *
     * @return array<int,mixed>
     */
    public function toArray() : array;
}
