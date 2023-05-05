<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerContainer;

use Look\Application\Messenger\MessengerOption\AbstractMessengerOptionContainer;
use Look\Application\Messenger\MessengerOption\Exception\FailedAddOptionException;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionFactoryInterface;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionInterface;
use Look\Application\Messenger\MessengerOption\MessengerKeyboardOption\MessengerKeyboardOptionName;

class MessengerKeyboardOptionContainer extends AbstractMessengerOptionContainer
{
    public function __construct(
        protected MessengerOptionFactoryInterface $optionFactory
    ) {
    }

    public function addOption(MessengerOptionInterface $option): void
    {
        if (!MessengerKeyboardOptionName::tryFrom($option->getName())) {
            throw new FailedAddOptionException("Undefined option {$option->getName()} for keyboard");
        }

        parent::addOption($option);
    }

    protected function makeNullOption(): MessengerOptionInterface
    {
        return $this->optionFactory->makeNullKeyboardOption();
    }
}
