<?php

declare(strict_types=1);

namespace Look\Application\Messenger;

use Look\Domain\Entity\Client\Interface\ClientInterface;
use Look\Domain\Messenger\Interface\MessengerHandlerInterface;
use Look\Domain\Messenger\Interface\MessengerInterface;
use Look\Domain\Messenger\Interface\MessengerRequestInterface;

class AddSupportMessengerHandler implements MessengerHandlerInterface
{
    public function handle(
        MessengerRequestInterface $request,
        MessengerInterface $messenger,
        ClientInterface $client
    ): void {
        $messenger->sendMessage(__('telegram.support_add_message'));
    }
}
