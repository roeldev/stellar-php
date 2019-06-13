<?php declare(strict_types=1);

namespace Stellar\Exceptions\Abilities;

trait CorrectTraceTrait
{
    public function correctTrace(int $index = 0) : self {
        $traces = $this->getTrace();
        if (isset($traces[$trace])) {
            $trace = $traces[ $index ];
            $this->file = $trace['file'];
            $this->line = $trace['line'];
        }

        return $this;
    }
}
