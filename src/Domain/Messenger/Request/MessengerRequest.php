<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Request;

use Look\Domain\Messenger\Interface\MessengerRequestInterface;

class MessengerRequest implements MessengerRequestInterface
{
    protected string $message = '';

    protected array $callbackQuery = [];

    public function setMessage(string $message): MessengerRequestInterface
    {
        $this->message = $message;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setCallbackQuery(array $callbackQuery): MessengerRequestInterface
    {
        $this->callbackQuery = $callbackQuery;
        return $this;
    }

    public function getCallbackQuery(): array
    {
        return $this->callbackQuery;
    }
}
