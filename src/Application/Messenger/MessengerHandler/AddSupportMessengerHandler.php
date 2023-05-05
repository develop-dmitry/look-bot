<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler;

use Look\Application\Messenger\MessengerContext\MessengerContextInterface;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerInterface;
use Look\Application\Messenger\MessengerVisual\MessengerVisualInterface;

class AddSupportMessengerHandler implements MessengerHandlerInterface
{
    public function handle(MessengerContextInterface $context, MessengerVisualInterface $visual): void {
        $visual->sendMessage(__('telegram.support_add_message'));
    }
}
