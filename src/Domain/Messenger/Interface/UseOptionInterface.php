<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

use Look\Domain\Messenger\Exception\FailedAddOptionException;

interface UseOptionInterface
{
    /**
     * @param OptionInterface $option
     * @return self
     * @throws FailedAddOptionException
     */
    public function addOption(OptionInterface $option): static;

    /**
     * @param string $optionName
     * @return OptionInterface
     */
    public function getOption(string $optionName): OptionInterface;

    /**
     * @return OptionContainerInterface
     */
    public function getOptions(): OptionContainerInterface;
}
