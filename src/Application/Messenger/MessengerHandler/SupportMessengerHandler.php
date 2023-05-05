<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler;

use Look\Application\Messenger\MessengerContext\MessengerContextInterface;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerName;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerInterface;
use Look\Application\Messenger\MessengerVisual\MessengerVisualInterface;

class SupportMessengerHandler implements MessengerHandlerInterface
{
    public function handle(MessengerContextInterface $context, MessengerVisualInterface $visual): void
    {
        if ($context->isIdentifiedMessengerUser()) {
            $context->getMessengerUser()?->setMessengerHandler(MessengerHandlerName::AddSupportMessage);
            $visual->sendMessage(__('telegram.support_message'));
        } else {
            $visual->sendMessage('Произошла ошибка, попробуйте позднее');
        }
    }
}
