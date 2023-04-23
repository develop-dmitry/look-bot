<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Option;

use Look\Domain\Messenger\Exception\FailedAddOptionException;
use Look\Domain\Messenger\Interface\OptionContainerInterface;
use Look\Domain\Messenger\Interface\OptionInterface;
use PhpOption\Option;

trait HasOption
{
    protected OptionContainerInterface $optionContainer;

    public function __construct(OptionContainerInterface $optionContainer)
    {
        $this->optionContainer = $optionContainer;
    }

    /**
     * @throws FailedAddOptionException
     */
    public function addOption(OptionInterface $option): static
    {
        $this->optionContainer->addOption($option);
        return $this;
    }

    public function getOptions(): OptionContainerInterface
    {
        return $this->optionContainer;
    }

    public function getOption(string $optionName): OptionInterface
    {
        return $this->optionContainer->getOption($optionName);
    }

    public function setOptionContainer(OptionContainerInterface $optionContainer): void
    {
        $this->optionContainer = $optionContainer;
    }
}
