<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler\Trait\Menu;

use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonInterfaceMessenger;
use Look\Application\Messenger\MessengerKeyboard\Exception\FailedAddRowKeyboardException;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardInterface;
use Look\Application\Messenger\MessengerOption\Exception\FailedAddOptionException;
use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionNameException;
use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionValueException;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionInterface;
use Look\Application\Messenger\MessengerOption\MessengerKeyboardOption\MessengerKeyboardOptionName;

trait HasMenu
{
    /**
     * @return MessengerKeyboardInterface
     * @throws FailedBuildMenuException
     */
    public function getMenuKeyboard(): MessengerKeyboardInterface
    {
        try {
            $keyboard = $this->keyboardFactory->makeReplyKeyboard();

            foreach ($this->getKeyboardOptions() as $option) {
                $keyboard->addOption($option);
            }


            foreach ($this->getMenuButtons() as $button) {
                $keyboard->addRow($button);
            }

            return $keyboard;
        } catch (
            FailedSetOptionNameException|
            FailedAddRowKeyboardException|
            FailedAddOptionException|
            FailedSetOptionValueException $exception
        ) {
            throw new FailedBuildMenuException($exception->getMessage());
        }
    }

    /**
     * @return MessengerButtonInterfaceMessenger[]
     */
    protected function getMenuButtons(): array
    {
        $buttons[] = $this->buttonFactory->makeReplyButton()
            ->setText(__('telegram.menu.about'));

        $buttons[] = $this->buttonFactory->makeReplyButton()
            ->setText(__('telegram.menu.support'));

        return $buttons;
    }

    /**
     * @return MessengerOptionInterface[]
     * @throws FailedSetOptionNameException
     * @throws FailedSetOptionValueException
     */
    protected function getKeyboardOptions(): array
    {
        $options[] = $this->optionFactory->makeKeyboardOption()
            ->setName(MessengerKeyboardOptionName::ResizeKeyboard->value)
            ->setValue(true);

        return $options;
    }
}