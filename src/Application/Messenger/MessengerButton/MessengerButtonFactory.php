<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerButton;

use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonFactoryInterface;
use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonInterfaceMessenger;
use Look\Application\Messenger\MessengerContainer\Interface\MessengerContainerFactoryInterface;

class MessengerButtonFactory implements MessengerButtonFactoryInterface
{
    public function __construct(
        protected MessengerContainerFactoryInterface $messengerContainerFactory
    ) {
    }

    public function makeInlineButton(): MessengerButtonInterfaceMessenger
    {
        return new InlineMessengerButton($this->messengerContainerFactory->makeButtonOptionContainer());
    }

    public function makeReplyButton(): MessengerButtonInterfaceMessenger
    {
        return new ReplyMessengerButton($this->messengerContainerFactory->makeButtonOptionContainer());
    }
}
