<?php declare(strict_types=1);

namespace Stellar\Exceptions\Testing\Constraints;

use PHPUnit\Framework\ExpectationFailedException;
use Stellar\Exceptions\Severity;
use SebastianBergmann\Comparator\ComparisonFailure;

class SameSeverity extends Constraint
{
    /**
     * @param mixed  $other        Value or object to evaluate
     * @param string $description  Additional information about the test
     * @param bool   $returnResult Whether to return a result or throw an exception
     *
     * @return mixed
     * @throws ExpectationFailedException
     */
    public function evaluate($other, $description = '', $returnResult = false)
    {
        $success = (($other instanceof Severity) && $this->value === $other);
        if ($returnResult) {
            return $success;
        }

        if (!$success) {
            $this->fail(
                $other,
                $description,
                new ComparisonFailure($this->value, $other, "'{$this->value}'", "'{$other}'")
            );
        }
    }

    public function toString() : string
    {
        return 'the Severity levels are the same';
    }
}
