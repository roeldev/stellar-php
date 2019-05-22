<?php declare(strict_types=1);

namespace Stellar\Curl\Options;

use Stellar\Curl\Contracts\OptionsInterface;

abstract class AbstractOptions implements OptionsInterface
{
    /** @var array<int,mixed> */
    protected $_options = [];

    public function __debugInfo()
    {
        return Utils::constantNamesKeys($this->_options);
    }

    /** {@inheritdoc} */
    public function with(OptionsInterface $options) : self
    {
        $this->_options = Utils::merge($this->_options, $options->toArray());

        return $this;
    }

    /** {@inheritdoc} */
    public function toArray() : array
    {
        return $this->_options;
    }
}
