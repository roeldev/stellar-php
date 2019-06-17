<?php declare(strict_types=1);

namespace Stellar\Exceptions\Contracts;

use Stellar\Common\Contracts\ArrayableInterface;
use Stellar\Common\Contracts\StringableInterface;
use Throwable;

interface ThrowableInterface extends ArrayableInterface, StringableInterface, Throwable
{
    public function getArguments() : array;
}
