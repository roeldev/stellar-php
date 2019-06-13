<?php declare(strict_types=1);

namespace Stellar\Exceptions\Abilities;

use Stellar\Exceptions\Contracts\ThrowableInterface;

trait ArrayableTrait
{
    /**
     * Transform the Exception to an array.
     */
    public function toArray() : array
    {
        $result = [
            'exception' => static::class,
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
        ];

        if ($this instanceof ThrowableInterface) {
            $result['arguments'] = $this->getArguments();
        }

        return $result;
    }
}
