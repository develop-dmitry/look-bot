<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerRequest\Interface;

interface MessengerRequestInterface
{
    /**
     * @param string $message
     * @return self
     */
    public function setMessage(string $message): self;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @param array $callbackQuery
     * @return self
     */
    public function setCallbackQuery(array $callbackQuery): self;

    /**
     * @return array
     */
    public function getCallbackQuery(): array;
}
