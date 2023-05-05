<?php

declare(strict_types=1);

namespace Look\Infrastructure\Repository\MessengerUserRepository;

class TelegramMessengerUserRepository extends AbstractMessengerUserRepository
{
    protected string $messengerCode = 'telegram';
}
