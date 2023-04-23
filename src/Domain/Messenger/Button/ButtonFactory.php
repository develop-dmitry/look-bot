<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Button;

use Look\Domain\Messenger\Interface\ButtonFactoryInterface;
use Look\Domain\Messenger\Interface\ButtonInterface;
use Look\Domain\Messenger\Interface\MessengerContainerFactoryInterface;

class ButtonFactory implements ButtonFactoryInterface
{
    public function __construct(
        protected MessengerContainerFactoryInterface $messengerContainerFactory
    ) {
    }

    public function makeInlineButton(): ButtonInterface
    {
        return new InlineButton($this->messengerContainerFactory->makeButtonOptionContainer());
    }

    public function makeReplyButton(): ButtonInterface
    {
        return new ReplyButton($this->messengerContainerFactory->makeButtonOptionContainer());
    }
}
