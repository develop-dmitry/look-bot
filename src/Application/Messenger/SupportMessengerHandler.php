<?php

declare(strict_types=1);

namespace Look\Application\Messenger;

use Look\Domain\Entity\Client\Interface\ClientInterface;
use Look\Domain\Messenger\Handler\MessengerHandlerName;
use Look\Domain\Messenger\Interface\MessengerHandlerInterface;
use Look\Domain\Messenger\Interface\MessengerInterface;
use Look\Domain\Messenger\Interface\MessengerRequestInterface;
use Look\Domain\Storage\Exception\StorageException;

class SupportMessengerHandler implements MessengerHandlerInterface
{
    public function handle(
        MessengerRequestInterface $request,
        MessengerInterface $messenger,
        ClientInterface $client
    ): void {
        try {
            $messenger->setNextMessageHandler(MessengerHandlerName::AddSupportMessage);
            $messenger->sendMessage(__('telegram.support_message'));
        } catch (StorageException) {
            $messenger->sendTechnicalErrorMessage();
        }
    }
}
