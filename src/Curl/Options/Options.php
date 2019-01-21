<?php declare(strict_types=1);

namespace Stellar\Curl\Options;

use Stellar\Curl\Exceptions\InvalidOption;
use Stellar\Curl\Support\Utils;

class Options extends AbstractOptions
{
    public function __construct(?array $options = null)
    {
        if (!empty($options)) {
            $this->withOptions($options);
        }
    }

    /**
     * @param array<int,mixed> $options
     */
    public function withOptions(array $options) : self
    {
        $options = Utils::filter($options);
        $this->_options = Utils::merge($this->_options, $options);

        return $this;
    }

    /**
     * @param int|string $option
     * @param mixed      $value
     */
    public function withOption($option, $value) : self
    {
        if (Utils::isValidStr($option)) {
            $option = \constant($option);
        }
        elseif (!Utils::isValidInt($option)) {
            throw InvalidOption::factory($option, $value)->create();
        }

        $this->_options[ $option ] = $value;

        return $this;
    }
}
