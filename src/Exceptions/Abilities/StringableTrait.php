<?php declare(strict_types=1);

namespace Stellar\Exceptions\Abilities;

use Stellar\Common\Traits\ToString;
use Stellar\Exceptions\Contracts\ThrowableInterface;

trait StringableTrait
{
    use ToString;

    /**
     * Get a string representation of the exception.
     */
    public function __toString() : string
    {
        $result = [ static::class, $this->getMessage() ];

        $code = $this->getCode();
        if (!empty($code)) {
            $result[] = '(' . $code . ')';
        }

        return \implode(' ', $result);
    }
}
