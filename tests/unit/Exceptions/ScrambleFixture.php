<?php

namespace UnitTests\Exceptions;

use Stellar\Exceptions\Exception;
use Stellar\Exceptions\ExceptionFactory;

class ScrambleFixture
{
    protected $_data;

    public function __construct() {
        $this->_data = [
            'password' => 'secret'
        ];

        throw Exception::factory()->create();
    }
}
