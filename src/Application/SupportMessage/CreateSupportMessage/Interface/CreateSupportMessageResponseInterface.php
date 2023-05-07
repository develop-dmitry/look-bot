<?php

declare(strict_types=1);

namespace Look\Application\SupportMessage\CreateSupportMessage\Interface;

interface CreateSupportMessageResponseInterface
{
    /**
     * @return bool
     */
    public function isSuccess(): bool;

    public function getError(): string;
}
