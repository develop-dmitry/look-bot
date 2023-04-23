<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Keyboard;

use Look\Domain\Messenger\Exception\FailedAddRowKeyboardException;
use Look\Domain\Messenger\Interface\ButtonInterface;
use Look\Domain\Messenger\Interface\KeyboardInterface;
use Look\Domain\Messenger\Interface\OptionContainerInterface;
use Look\Domain\Messenger\Option\HasOption;

abstract class AbstractKeyboard implements KeyboardInterface
{
    use HasOption;

    /**
     * @var ButtonInterface[][]
     */
    protected array $rows;

    public function __construct(OptionContainerInterface $optionContainer) {
        $this->setOptionContainer($optionContainer);
    }

    public function addRow(ButtonInterface ...$buttons): void
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

    abstract protected function buttonCanBeAdded(ButtonInterface $button): bool;
}
