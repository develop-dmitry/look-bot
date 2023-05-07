<?php

declare(strict_types=1);

namespace Look\Application\SupportMessage\CreateSupportMessage;

use Look\Application\SupportMessage\CreateSupportMessage\Interface\CreateSupportMessageResponseInterface;

class CreateSupportMessageResponse implements CreateSupportMessageResponseInterface
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
