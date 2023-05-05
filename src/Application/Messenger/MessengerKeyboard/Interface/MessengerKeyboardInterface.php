<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerKeyboard\Interface;

use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonInterfaceMessenger;
use Look\Application\Messenger\MessengerKeyboard\Exception\FailedAddRowKeyboardException;
use Look\Application\Messenger\MessengerKeyboard\MessengerKeyboardType;
use Look\Application\Messenger\MessengerOption\Interface\UseMessengerOptionInterface;

interface MessengerKeyboardInterface extends UseMessengerOptionInterface
{
    /**
     * @param MessengerButtonInterfaceMessenger ...$buttons
     * @return void
     * @throws FailedAddRowKeyboardException
     */
    public function addRow(MessengerButtonInterfaceMessenger ...$buttons): void;

    /**
     * @return MessengerButtonInterfaceMessenger[][]
     */
    public function getRows(): array;

    public function getType(): MessengerKeyboardType;
}
