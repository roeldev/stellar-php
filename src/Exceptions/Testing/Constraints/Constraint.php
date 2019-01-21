<?php declare(strict_types=1);

namespace Stellar\Exceptions\Testing\Constraints;

use PHPUnit\Framework\Constraint\Constraint as PHPUnitConstraint;

abstract class Constraint extends PHPUnitConstraint
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        parent::__construct();
        $this->value = $value;
    }

    final protected function failureDescription($other) : string
    {
        return $this->toString();
    }
}
