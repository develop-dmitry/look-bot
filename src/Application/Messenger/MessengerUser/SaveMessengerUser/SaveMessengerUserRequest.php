<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerUser\SaveMessengerUser;

use Look\Application\Messenger\MessengerUser\SaveMessengerUser\Interface\SaveMessengerUserRequestInterface;
use Look\Domain\MessengerUser\MessengerUser;

class SaveMessengerUserRequest implements SaveMessengerUserRequestInterface
{
    public function __construct(
        protected MessengerUser $messengerUser
    ) {
    }

    public function getMessengerUser(): MessengerUser
    {
        return $this->messengerUser;
    }
}
