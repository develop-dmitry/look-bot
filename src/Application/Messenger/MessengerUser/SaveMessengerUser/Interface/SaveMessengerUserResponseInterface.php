<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerUser\SaveMessengerUser\Interface;

interface SaveMessengerUserResponseInterface
{
    /**
     * @return bool
     */
    public function isSuccess(): bool;

    /**
     * @return string
     */
    public function getError(): string;
}
