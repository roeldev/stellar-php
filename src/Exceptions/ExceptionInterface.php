<?php declare(strict_types=1);

namespace Stellar\Exceptions;

interface ExceptionInterface extends ThrowableInterface
{
    public function setSeverity(Severity $severity);

    public function setArguments(array $arguments);
}
