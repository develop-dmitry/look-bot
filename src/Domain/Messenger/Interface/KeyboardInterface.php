<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

use Look\Domain\Messenger\Exception\FailedAddRowKeyboardException;
use Look\Domain\Messenger\Keyboard\KeyboardType;

interface KeyboardInterface extends UseOptionInterface
{
    /**
     * @param ButtonInterface ...$buttons
     * @return void
     * @throws FailedAddRowKeyboardException
     */
    public function addRow(ButtonInterface ...$buttons): void;

    /**
     * @return ButtonInterface[][]
     */
    public function getRows(): array;

    public function getType(): KeyboardType;
}
