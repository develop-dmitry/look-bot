<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerOption;

use Look\Application\Messenger\MessengerContainer\Interface\MessengerOptionContainerInterface;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionInterface;

abstract class AbstractMessengerOptionContainer implements MessengerOptionContainerInterface
{
    protected array $options = [];

    public function addOption(MessengerOptionInterface $option): void
    {
        $this->options[$option->getName()] = $option;
    }

    public function getOption(string $optionName): MessengerOptionInterface
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

    abstract protected function makeNullOption(): MessengerOptionInterface;
}
