<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerUser\SaveMessengerUser\Interface;

use Look\Domain\MessengerUser\MessengerUser;

interface SaveMessengerUserRequestInterface
{
    /**
     * @return MessengerUser
     */
    public function getMessengerUser(): MessengerUser;
}
