<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerOption;

use Look\Application\Messenger\MessengerContainer\Interface\MessengerOptionContainerInterface;
use Look\Application\Messenger\MessengerOption\Exception\FailedAddOptionException;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionInterface;

trait HasMessengerOption
{
    protected MessengerOptionContainerInterface $optionContainer;

    public function __construct(MessengerOptionContainerInterface $optionContainer)
    {
        $this->optionContainer = $optionContainer;
    }

    /**
     * @throws FailedAddOptionException
     */
    public function addOption(MessengerOptionInterface $option): static
    {
        $this->optionContainer->addOption($option);
        return $this;
    }

    public function getOptions(): MessengerOptionContainerInterface
    {
        return $this->optionContainer;
    }

    public function getOption(string $optionName): MessengerOptionInterface
    {
        return $this->optionContainer->getOption($optionName);
    }

    public function setOptionContainer(MessengerOptionContainerInterface $optionContainer): void
    {
        $this->optionContainer = $optionContainer;
    }
}
