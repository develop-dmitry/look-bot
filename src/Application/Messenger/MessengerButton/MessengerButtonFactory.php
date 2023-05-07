<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerButton;

use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonFactoryInterface;
use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonInterface;
use Look\Application\Messenger\MessengerContainer\Interface\MessengerContainerFactoryInterface;
use Look\Application\Messenger\MessengerOption\Exception\FailedAddOptionException;
use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionNameException;
use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionValueException;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionFactoryInterface;
use Look\Application\Messenger\MessengerOption\MessengerButtonOption\MessengerButtonOptionName;

class MessengerButtonFactory implements MessengerButtonFactoryInterface
{
    public function __construct(
        protected MessengerContainerFactoryInterface $messengerContainerFactory,
        protected MessengerOptionFactoryInterface $optionFactory
    ) {
    }

    public function makeInlineButton(): MessengerButtonInterface
    {
        return new InlineMessengerButton($this->messengerContainerFactory->makeButtonOptionContainer());
    }

    public function makeReplyButton(): MessengerButtonInterface
    {
        return new ReplyMessengerButton($this->messengerContainerFactory->makeButtonOptionContainer());
    }

    public function makeLocationReplyButton(): MessengerButtonInterface
    {

        return $this->makeReplyButton()
            ->addOption(
                $this->optionFactory->makeButtonOption()
                    ->setName(MessengerButtonOptionName::RequestLocation->value)
                    ->setValue(true)
            );
    }

    public function makeCallbackDataInlineButton(array $callbackData): MessengerButtonInterface
    {
        $button = $this->makeInlineButton();

        $button->addOption(
            $this->optionFactory->makeCallbackDataButtonOption()
                ->setName(MessengerButtonOptionName::CallbackData->value)
                ->setValue($callbackData)
        );

        return $button;
    }
}
