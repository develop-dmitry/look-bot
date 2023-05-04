<?php

declare(strict_types=1);

namespace Look\Infrastructure\Repository\MessengerUserRepository;

use Look\Domain\Entity\MessengerUser\Interface\TelegramMessengerUserRepositoryInterface;

class RedisTelegramMessengerUserRepository extends AbstractRedisMessengerUserRepository
    implements TelegramMessengerUserRepositoryInterface
{
    protected string $messengerCode = 'telegram';
}
