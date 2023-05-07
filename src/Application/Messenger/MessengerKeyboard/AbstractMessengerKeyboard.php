<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerKeyboard;

use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonInterface;
use Look\Application\Messenger\MessengerContainer\Interface\MessengerOptionContainerInterface;
use Look\Application\Messenger\MessengerKeyboard\Exception\FailedAddRowKeyboardException;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardInterface;
use Look\Application\Messenger\MessengerOption\HasMessengerOption;

abstract class AbstractMessengerKeyboard implements MessengerKeyboardInterface
{
    use HasMessengerOption;

    /**
     * @var MessengerButtonInterface[][]
     */
    protected array $rows = [];

    public function __construct(MessengerOptionContainerInterface $optionContainer) {
        $this->setOptionContainer($optionContainer);
    }

    public function addRow(MessengerButtonInterface ...$buttons): void
    {
        foreach ($buttons as $button) {
            if (!$this->buttonCanBeAdded($button)) {
                $buttonType = $button->getType()->value;
                $keyboardType = $this->getType()->value;

                throw new FailedAddRowKeyboardException(
                    "Button with type $buttonType can not be add to $keyboardType keyboard"
                );
            }
        }

        $this->rows[] = $buttons;
    }

    public function getRows(): array
    {
        return $this->rows;
    }

    abstract protected function buttonCanBeAdded(MessengerButtonInterface $button): bool;
}
