<?php

declare(strict_types=1);

namespace Look\Application\Messenger\Menu;

use Look\Domain\Messenger\Exception\FailedAddOptionException;
use Look\Domain\Messenger\Exception\FailedAddRowKeyboardException;
use Look\Domain\Messenger\Exception\FailedSetOptionNameException;
use Look\Domain\Messenger\Exception\FailedSetOptionValueException;
use Look\Domain\Messenger\Interface\ButtonFactoryInterface;
use Look\Domain\Messenger\Interface\ButtonInterface;
use Look\Domain\Messenger\Interface\KeyboardFactoryInterface;
use Look\Domain\Messenger\Interface\KeyboardInterface;
use Look\Domain\Messenger\Interface\OptionFactoryInterface;
use Look\Domain\Messenger\Interface\OptionInterface;
use Look\Domain\Messenger\Option\KeyboardOption\KeyboardOptionName;

trait HasMenu
{
    protected KeyboardFactoryInterface $keyboardFactory;

    protected ButtonFactoryInterface $buttonFactory;

    protected OptionFactoryInterface $optionFactory;

    /**
     * @return KeyboardInterface
     * @throws FailedBuildMenuException
     */
    public function getMenuKeyboard(): KeyboardInterface
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
     * @return ButtonInterface[]
     */
    protected function getMenuButtons(): array
    {
        $buttons[] = $this->buttonFactory->makeReplyButton()
            ->setText(__('telegram.menu.about'));

        return $buttons;
    }

    /**
     * @return OptionInterface[]
     * @throws FailedSetOptionNameException
     * @throws FailedSetOptionValueException
     */
    protected function getKeyboardOptions(): array
    {
        $options[] = $this->optionFactory->makeKeyboardOption()
            ->setName(KeyboardOptionName::ResizeKeyboard->value)
            ->setValue(true);

        return $options;
    }

    protected function setKeyboardFactory(KeyboardFactoryInterface $keyboardFactory): void
    {
        $this->keyboardFactory = $keyboardFactory;
    }

    protected function setButtonFactory(ButtonFactoryInterface $buttonFactory): void
    {
        $this->buttonFactory = $buttonFactory;
    }

    protected function setOptionFactory(OptionFactoryInterface $optionFactory): void
    {
        $this->optionFactory = $optionFactory;
    }
}
