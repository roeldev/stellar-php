<?php declare(strict_types=1);

namespace Stellar\Exceptions\Abilities;

use Stellar\Common\Abilities\StringableTrait;
use Stellar\Common\Stringify;
use Stellar\Common\StringUtil;
use Stellar\Exceptions\Contracts\ThrowableInterface;

trait ExtendExceptionTrait
{
    use SetCodeTrait;
    use StringableTrait;

    /** @var string */
    private $_message;

    /** @var array */
    protected $_arguments = [];

    /**
     * @return $this
     */
    private function _withArguments(array $arguments) : self
    {
        if (!$this->_message) {
            $this->_message = $this->message;
        }

        if (!empty($arguments)) {
            $this->_arguments = $arguments;
            $this->message = StringUtil::replaceVars(
                $this->_message,
                \array_map([ Stringify::class, 'any' ], $arguments)
            );
        }

        return $this;
    }

    /**
     * @return $this
     */
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
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
        ];

        if ($this instanceof ThrowableInterface) {
            $result['arguments'] = $this->getArguments();
        }

        return $result;
    }

    /**
     * Get a string representation of the exception.
     */
    public function __toString() : string
    {
        $result = [ static::class, $this->getMessage() ];

        $code = $this->getCode();
        if (!empty($code)) {
            $result[] = '(' . $code . ')';
        }

        return \implode(' ', $result);
    }
}
