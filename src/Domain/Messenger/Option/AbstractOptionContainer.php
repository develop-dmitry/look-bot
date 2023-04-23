<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Option;

use Look\Domain\Messenger\Interface\OptionContainerInterface;
use Look\Domain\Messenger\Interface\OptionInterface;

abstract class AbstractOptionContainer implements OptionContainerInterface
{
    protected array $options = [];

    public function addOption(OptionInterface $option): void
    {
        $this->options[$option->getName()] = $option;
    }

    public function getOption(string $optionName): OptionInterface
    {
        if ($this->hasOption($optionName)) {
            return $this->options[$optionName];
        }

        return $this->makeNullOption();
    }

    public function hasOption(string $optionName): bool
    {
        return isset($this->options[$optionName]);
    }

    abstract protected function makeNullOption(): OptionInterface;
}
