<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Option\ButtonOption;

use Look\Domain\Messenger\Exception\FailedAddOptionException;
use Look\Domain\Messenger\Interface\OptionFactoryInterface;
use Look\Domain\Messenger\Interface\OptionInterface;
use Look\Domain\Messenger\Option\AbstractOptionContainer;

class ButtonOptionContainer extends AbstractOptionContainer
{
    public function __construct(
        protected OptionFactoryInterface $optionFactory
    ) {
    }

    public function addOption(OptionInterface $option): void
    {
        if (!ButtonOptionName::tryFrom($option->getName())) {
            throw new FailedAddOptionException("Undefined option {$option->getName()} for button");
        }

        parent::addOption($option);
    }

    protected function makeNullOption(): OptionInterface
    {
        return $this->optionFactory->makeNullButtonOption();
    }
}
