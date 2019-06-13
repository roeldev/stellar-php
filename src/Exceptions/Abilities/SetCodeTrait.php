<?php declare(strict_types=1);

namespace Stellar\Exceptions\Abilities;

trait SetCodeTrait
{
    public function setCode(int $code) : self
    {
        $this->code = $code;

        return $this;
    }
}
