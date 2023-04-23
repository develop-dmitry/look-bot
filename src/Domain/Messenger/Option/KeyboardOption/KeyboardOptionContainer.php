<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Option\KeyboardOption;

use Look\Domain\Messenger\Exception\FailedAddOptionException;
use Look\Domain\Messenger\Interface\OptionFactoryInterface;
use Look\Domain\Messenger\Interface\OptionInterface;
use Look\Domain\Messenger\Option\AbstractOptionContainer;

class KeyboardOptionContainer extends AbstractOptionContainer
{
    public function __construct(
        protected OptionFactoryInterface $optionFactory
    ) {
    }

    public function addOption(OptionInterface $option): void
    {
        if (!KeyboardOptionName::tryFrom($option->getName())) {
            throw new FailedAddOptionException("Undefined option {$option->getName()} for keyboard");
        }

        parent::addOption($option);
    }

    protected function makeNullOption(): OptionInterface
    {
        return $this->optionFactory->makeNullKeyboardOption();
    }
}
