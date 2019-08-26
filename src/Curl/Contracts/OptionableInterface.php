<?php declare(strict_types=1);

namespace Stellar\Curl\Contracts;

interface OptionableInterface
{
    /**
     * Add the options to the current chain or request.
     *
     * @return $this
     */
    public function with(OptionsInterface $options);
}
