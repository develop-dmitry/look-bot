<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler;

use Look\Application\Dictionary\DictionaryInterface;
use Look\Application\Messenger\MessengerContext\MessengerContextInterface;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerName;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerType;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerInterface;
use Look\Application\Messenger\MessengerVisual\MessengerVisualInterface;

class AddSupportMessengerHandler implements MessengerHandlerInterface
{
    public function __construct(
        protected DictionaryInterface $dictionary
    ) {
    }

    public function handle(MessengerContextInterface $context, MessengerVisualInterface $visual): void {
        $visual->sendMessage($this->dictionary->getTranslate('telegram.support.add_message'));
    }

    public function getTypes(): array
    {
        return [MessengerHandlerType::Message];
    }

    public function getNames(): array
    {
        return [MessengerHandlerName::AddSupportMessage];
    }
}
