<?php

declare(strict_types=1);

namespace Look\Infrastructure\Messenger\TelegramMessenger;

use Illuminate\Database\Eloquent\Casts\Json;
use Look\Application\Client\IdentifyClient\IdentifyClientRequest;
use Look\Application\Client\IdentifyClient\Interface\IdentifyClientInterface;
use Look\Application\Messenger\MessengerContext\MessengerContextInterface;
use Look\Application\Messenger\MessengerRequest\Interface\MessengerRequestFactoryInterface;
use Look\Application\Messenger\MessengerRequest\Interface\MessengerRequestInterface;
use Look\Application\Messenger\MessengerUser\FindMessengerUser\FindMessengerUserRequest;
use Look\Application\Messenger\MessengerUser\FindMessengerUser\Interface\FindMessengerUserInterface;
use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\MessengerUser\Interface\MessengerUserInterface;
use SergiX44\Nutgram\Nutgram;

class TelegramMessengerContext implements MessengerContextInterface
{
    protected MessengerRequestInterface $request;

    protected ?ClientInterface $client = null;

    protected ?MessengerUserInterface $messengerUser = null;

    protected bool $initialized = false;

    public function __construct(
        protected MessengerRequestFactoryInterface $messengerRequestFactory,
        protected IdentifyClientInterface $identifyClient,
        protected FindMessengerUserInterface $findMessengerUser,
        protected Nutgram $bot
    ) {
    }

    public function init(): void
    {
        if ($this->initialized) {
            return;
        }

        $this->initRequest();
        $this->identifyClient();

        if ($this->isIdentifiedClient()) {
            $this->identifyMessengerUser();
        }

        $this->initialized = true;
    }

    public function getRequest(): MessengerRequestInterface
    {
        return $this->request;
    }

    /**
     * @return ClientInterface|null
     */
    public function getClient(): ?ClientInterface
    {
        return $this->client;
    }

    /**
     * @return MessengerUserInterface|null
     */
    public function getMessengerUser(): ?MessengerUserInterface
    {
        return $this->messengerUser;
    }

    public function isIdentifiedClient(): bool
    {
        return !is_null($this->client);
    }

    public function isIdentifiedMessengerUser(): bool
    {
        return !is_null($this->messengerUser);
    }

    protected function initRequest(): void
    {
        $this->request = $this->messengerRequestFactory->makeMessengerRequest();

        $message = $this->bot->message()?->text;
        $callbackQuery = $this->bot->callbackQuery()?->data;

        $this->request->setMessage($message ?? '');
        $this->request->setCallbackQuery(($callbackQuery) ? Json::decode($callbackQuery) : []);
    }

    protected function identifyClient(): bool
    {
        $userId = $this->bot->userId();

        if (!$userId) {
            return false;
        }

        $request = new IdentifyClientRequest($userId);
        $response = $this->identifyClient->identifyClientFromTelegram($request);

        if ($response->isIdentified()) {
            $this->client = $response->getClient();
        }

        return $response->isIdentified();
    }

    protected function identifyMessengerUser(): void
    {
        $request = new FindMessengerUserRequest($this->client->getTelegramId()?->getValue());
        $response = $this->findMessengerUser->findMessengerUser($request);

        if ($response->isFound()) {
            $this->messengerUser = $response->getMessengerUser();
        }
    }
}
