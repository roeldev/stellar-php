<?php

namespace Stellar\Curl\Events;

use Stellar\Common\Contracts\ArrayableInterface;
use Stellar\Events\Event;

class MultiStatusEvent extends Event implements ArrayableInterface
{
    public $total;

    public $left;

    public $passes;

    public $status;

    public $error;

    public $errorMessage;

    public function __construct(int $total, int $left, int $passes = 0, int $status = 0, int $error = 0)
    {
        $this->total = $total;
        $this->left = $left;
        $this->passes = $passes;
        $this->status = $status;
        $this->error = $error;

        if (\CURLE_OK !== $error) {
            $this->errorMessage = \curl_strerror($error);
        }
    }

    public function toArray() : array
    {
        return \get_object_vars($this);
    }
}
