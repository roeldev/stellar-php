<?php declare(strict_types=1);

namespace Stellar\Exceptions\Abilities;

use Stellar\Common\Stringify;
use Stellar\Common\StringUtil;

trait ExtendExceptionTrait
{
    use ArrayableTrait;
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
}
