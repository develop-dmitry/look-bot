<?php

declare(strict_types=1);

namespace Look\Application\SupportMessage\CreateSupportMessage;

use Look\Application\SupportMessage\CreateSupportMessage\Interface\CreateSupportMessageRequestInterface;

class CreateSupportMessageRequest implements CreateSupportMessageRequestInterface
{
    public function __construct(
        protected int $clientId,
        protected string $context,
        protected string $message
    ) {
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getContext(): string
    {
        return $this->context;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

}
