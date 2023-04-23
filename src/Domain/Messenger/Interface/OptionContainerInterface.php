<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

use Look\Domain\Messenger\Exception\FailedAddOptionException;

interface OptionContainerInterface
{
    /**
     * @param OptionInterface $option
     * @return void
     * @throws FailedAddOptionException
     */
    public function addOption(OptionInterface $option): void;

    /**
     * @param string $optionName
     * @return mixed
     */
    public function getOption(string $optionName): OptionInterface;

    /**
     * @param string $optionName
     * @return bool
     */
    public function hasOption(string $optionName): bool;
}
