<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerContainer\Interface;

use Look\Application\Messenger\MessengerOption\Exception\FailedAddOptionException;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionInterface;

interface MessengerOptionContainerInterface
{
    /**
     * @param MessengerOptionInterface $option
     * @return void
     * @throws FailedAddOptionException
     */
    public function addOption(MessengerOptionInterface $option): void;

    /**
     * @param string $optionName
     * @return mixed
     */
    public function getOption(string $optionName): MessengerOptionInterface;

    /**
     * @param string $optionName
     * @return bool
     */
    public function hasOption(string $optionName): bool;
}
