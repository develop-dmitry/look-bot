<?php

declare(strict_types=1);

namespace Look\Application\Client\SaveClient;

use Look\Application\Client\SaveClient\Interface\SaveClientResponseInterface;

class SaveClientResponse implements SaveClientResponseInterface
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
