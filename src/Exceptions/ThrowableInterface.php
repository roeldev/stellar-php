<?php declare(strict_types=1);

namespace Stellar\Exceptions;

use Stellar\Common\Contracts\ArrayableInterface;
use Stellar\Common\Contracts\StringableInterface;

interface ThrowableInterface extends \Throwable, ArrayableInterface, StringableInterface
{
    /**
     * Get the Severity object which indicates the severity of the exception.
     */
    public function getSeverity() : Severity;

    public function getArguments() : array;
}
