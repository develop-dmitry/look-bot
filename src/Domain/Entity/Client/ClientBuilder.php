<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Client;

use Look\Domain\Builder\AbstractBuilder;
use Look\Domain\Builder\UseId\HasId;
use Look\Domain\Entity\Client\Interface\ClientBuilderInterface;
use Look\Domain\Entity\Client\Interface\ClientInterface;
use Look\Domain\Entity\MessengerUser\Interface\TelegramMessengerUserRepositoryInterface;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class ClientBuilder extends AbstractBuilder implements ClientBuilderInterface
{
    use HasId;

    protected ?int $telegramId = null;

    protected ?int $userId = null;

    public function __construct(
        protected ValueFactoryInterface $valueFactory,
        protected TelegramMessengerUserRepositoryInterface $telegramUserRepository
    ) {
    }

    public function setTelegramId(?int $telegramId): static
    {
        $this->values['telegram_id'] = $telegramId;
        return $this;
    }

    public function setUserId(?int $userId): static
    {
        $this->values['user_id'] = $userId;
        return $this;
    }

    public function fromArray(array $data): static
    {
        $this->values = array_merge($this->values, $data);
        return $this;
    }

    public function make(): ClientInterface
    {
        $client = new Client($this->valueFactory, $this->telegramUserRepository);

        $client
            ->setId($this->getValue('id'))
            ->setUserId($this->getValue('user_id'))
            ->setTelegramId($this->getValue('telegram_id'));

        $this->reset();

        return $client;
    }

    public function reset(): void
    {
        $this->id = null;
        $this->telegramId = null;
        $this->userId = null;
    }
}
