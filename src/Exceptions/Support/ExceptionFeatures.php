<?php declare(strict_types=1);

namespace Stellar\Exceptions\Support;

use Stellar\Support\Arr;
use Stellar\Common\Traits\ToString;
use Stellar\Exceptions\Severity;

trait ExceptionFeatures
{
    use ToString;

    /**
     * A Severity object which indicates the severity level of the exception.
     *
     * @var Severity
     */
    protected $_severity;

    /** @var array */
    protected $_arguments;

    protected function _updateFromTrace(int $index = 0) : void
    {
        $trace = $this->getTrace()[ $index ];

        $this->file = $trace['file'];
        $this->line = $trace['line'];
    }

    public function setSeverity(Severity $severity) : self
    {
        $this->_severity = $severity;

        return $this;
    }

    public function getSeverity() : Severity
    {
        if (null === $this->_severity) {
            $this->_severity = Severity::NOTICE();
        }

        return $this->_severity;
    }

    public function setArguments(array $arguments) : self
    {
        $this->_arguments = $arguments;

        return $this;
    }

    public function getArguments() : array
    {
        return $this->_arguments;
    }

    /**
     * Transform the Exception to an array.
     */
    public function toArray() : array
    {
        $result = [
            'exception' => static::class,
            'message'   => $this->getMessage(),
            'code'      => $this->getCode(),
            'file'      => $this->getFile(),
            'line'      => $this->getLine(),
        ];

        if ($this instanceof ErrorInterface) {
            $result['severity'] = Arr::withKeys($this->getSeverity()->toArray(), 'name', 'value');
            $result['arguments'] = $this->getArguments();
        }

        return $result;
    }

    /**
     * Get a string representation of the exception.
     */
    public function __toString() : string
    {
        $result = [ static::class ];

        if ($this instanceof ErrorInterface) {
            $result[] = '[' . $this->getSeverity()->getName() . ']';
        }

        $result[] = $this->getMessage();

        $code = $this->getCode();
        if (!empty($code)) {
            $result[] = '(' . $code . ')';
        }

        return \implode(' ', $result);
    }
}
