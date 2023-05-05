<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerUser\SaveMessengerUser;

use Look\Application\Messenger\MessengerUser\SaveMessengerUser\Interface\SaveMessengerUserResponseInterface;

class SaveMessengerUserResponse implements SaveMessengerUserResponseInterface
{
    public function __construct(
        protected bool $success,
        protected string $error = ''
    ) {
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getError(): string
    {
        return $this->error;
    }
}
