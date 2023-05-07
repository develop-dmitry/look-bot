<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerKeyboard\Interface;

use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonInterface;
use Look\Application\Messenger\MessengerKeyboard\Exception\FailedAddRowKeyboardException;
use Look\Application\Messenger\MessengerKeyboard\MessengerKeyboardType;
use Look\Application\Messenger\MessengerOption\Interface\UseMessengerOptionInterface;

interface MessengerKeyboardInterface extends UseMessengerOptionInterface
{
    /**
     * @param MessengerButtonInterface ...$buttons
     * @return MessengerKeyboardInterface
     * @throws FailedAddRowKeyboardException
     */
    public function addRow(MessengerButtonInterface ...$buttons): self;

    /**
     * @return MessengerButtonInterface[][]
     */
    public function getRows(): array;

    public function getType(): MessengerKeyboardType;
}
