<?php declare(strict_types=1);

namespace Stellar\Exceptions\Contracts;

interface ExceptionInterface extends ThrowableInterface
{
    /** @return $this */
    public function setCode(int $code);
}
