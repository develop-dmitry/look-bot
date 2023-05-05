<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerRequest;

use Look\Application\Messenger\MessengerRequest\Interface\MessengerRequestInterface;

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
