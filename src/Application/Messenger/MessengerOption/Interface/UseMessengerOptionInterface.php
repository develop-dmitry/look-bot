<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerOption\Interface;

use Look\Application\Messenger\MessengerContainer\Interface\MessengerOptionContainerInterface;
use Look\Application\Messenger\MessengerOption\Exception\FailedAddOptionException;

interface UseMessengerOptionInterface
{
    /**
     * @param MessengerOptionInterface $option
     * @return self
     * @throws FailedAddOptionException
     */
    public function addOption(MessengerOptionInterface $option): static;

    /**
     * @param string $optionName
     * @return MessengerOptionInterface
     */
    public function getOption(string $optionName): MessengerOptionInterface;

    /**
     * @return MessengerOptionContainerInterface
     */
    public function getOptions(): MessengerOptionContainerInterface;
}
