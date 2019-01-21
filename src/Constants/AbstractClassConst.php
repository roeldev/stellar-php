<?php declare(strict_types=1);

namespace Stellar\Constants;

use Stellar\Common\Contracts\ArrayableInterface;
use Stellar\Common\Contracts\StringableInterface;
use Stellar\Common\Traits\ToString;

abstract class AbstractClassConst implements ClassConstantInterface, ArrayableInterface, StringableInterface
{
    use ToString;

    /**
     * Full name of the class of which the const belongs to.
     *
     * @var string
     */
    protected $_class;

    /**
     * Name of the const.
     *
     * @var string
     */
    protected $_name;

    /**
     * Value of the const.
     *
     * @var mixed
     */
    protected $_value;

    public function getClass() : string
    {
        return $this->_class;
    }

    public function getName() : string
    {
        return $this->_name;
    }

    public function getConst() : string
    {
        return $this->_class . '::' . $this->_name;
    }

    public function getValue()
    {
        if (null === $this->_value) {
            $this->_value = \constant($this->getConst());
        }

        return $this->_value;
    }

    /** {@inheritdoc} */
    public function toArray() : array
    {
        return [
            'class' => $this->_class,
            'name'  => $this->_name,
            'const' => $this->getConst(),
            'value' => $this->getValue(),
        ];
    }

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getConst();
    }
}
