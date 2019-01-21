<?php

namespace Stellar\Curl\Response;

use Stellar\Common\Contracts\ArrayableInterface;
use Stellar\Json\Json;

class JsonResponse extends Response implements ArrayableInterface
{
    public function toArray() : array
    {
        return Json::decode($this->_body);
    }
}
