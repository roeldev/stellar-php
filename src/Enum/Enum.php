<?php declare(strict_types=1);

namespace Stellar\Enum;

use Stellar\Common\Traits\ToString;
use Stellar\Container\Registry;
use Stellar\Container\ServiceRequest;
use Stellar\Enum\Traits\EnumFeatures;
use Stellar\Exceptions\Common\UndefinedClassConstant;
use Stellar\Exceptions\Common\UnknownStaticMethod;

/**
 * @see:unit-test \UnitTests\Enum\EnumTests
 */
abstract class Enum implements EnumInterface
{
    use EnumFeatures;
    use ToString;

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return static
     * @throws UndefinedClassConstant
     * @throws UnknownStaticMethod
     */
    public static function __callStatic($name, $arguments)
    {
        $class = static::class;
        if ($class === __CLASS__ || \strtoupper($name) !== $name) {
            throw UnknownStaticMethod::factory($class, $name)->create();
        }
        if (!static::enum()->hasName($name)) {
            throw UndefinedClassConstant::factory($class, $name)->create();
        }

        // the instance has to be created inside Enum because it's constructor is protected
        return Registry::container($class)->request($name, function () use ($class, $name) {
            $service = new $class($class, $name);

            return ServiceRequest::with($service)->asSingleton();
        });
    }

    final protected function __construct(string $class, string $name)
    {
        $this->_class = $class;
        $this->_name = $name;
        $this->_value = \call_user_func($class . '::valueOf', \constant($this->getConst()));
    }

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

    /** {@inheritdoc} */
    public function getClass() : string
    {
        return $this->_class;
    }

    /** {@inheritdoc} */
    public function getName() : string
    {
        return $this->_name;
    }

    /** {@inheritdoc} */
    public function getConst() : string
    {
        return $this->_class . '::' . $this->_name;
    }

    /** {@inheritdoc} */
    public function getValue()
    {
        if (null === $this->_value) {
            $this->_value = \constant($this->getConst());
        }

        return $this->_value;
    }

    /** @inheritdoc */
    public function sameType(string $type) : bool
    {
        return $type === $this->getConst();
    }

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getConst();
    }
}
