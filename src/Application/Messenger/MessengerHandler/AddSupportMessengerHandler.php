<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler;

use Look\Application\Dictionary\DictionaryInterface;
use Look\Application\Messenger\MessengerContext\MessengerContextInterface;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerName;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerType;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerInterface;
use Look\Application\Messenger\MessengerVisual\MessengerVisualInterface;
use Look\Application\SupportMessage\CreateSupportMessage\CreateSupportMessageRequest;
use Look\Application\SupportMessage\CreateSupportMessage\Interface\CreateSupportMessageInterface;
use Look\Application\SupportMessage\CreateSupportMessage\Interface\CreateSupportMessageRequestInterface;

class AddSupportMessengerHandler implements MessengerHandlerInterface
{
    protected MessengerContextInterface $context;

    public function __construct(
        protected DictionaryInterface $dictionary,
        protected CreateSupportMessageInterface $createSupportMessage
    ) {
    }

    public function handle(MessengerContextInterface $context, MessengerVisualInterface $visual): void
    {
        if (!$context->isIdentifiedClient()) {
            $visual->sendMessage($this->dictionary->getTranslate('telegram.unknown_client'));
            return;
        }

        $this->context = $context;

        $request = $this->makeCreateSupportMessageRequest();
        $response = $this->createSupportMessage->createSupportMessage($request);

        if ($response->isSuccess()) {
            $visual->sendMessage($this->dictionary->getTranslate('telegram.support.add_message'));
        } else {
            $visual->sendMessage($response->getError());
        }
    }

    public function getTypes(): array
    {
        return [MessengerHandlerType::Message];
    }

    public function getNames(): array
    {
        return [MessengerHandlerName::AddSupportMessage];
    }

    protected function makeCreateSupportMessageRequest(): CreateSupportMessageRequestInterface
    {
        $request = $this->context->getRequest();

        return new CreateSupportMessageRequest(
            $this->context->getClient()->getId()->getValue(),
            'Telegram Bot',
            $request->getMessage()
        );
    }
}
