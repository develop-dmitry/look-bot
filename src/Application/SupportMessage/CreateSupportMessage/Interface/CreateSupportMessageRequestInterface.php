<?php

declare(strict_types=1);

namespace Look\Application\SupportMessage\CreateSupportMessage\Interface;

use Look\Domain\Value\Id\Id;

interface CreateSupportMessageRequestInterface
{
    /**
     * @return int
     */
    public function getClientId(): int;

    /**
     * @return string
     */
    public function getContext(): string;

    /**
     * @return string
     */
    public function getMessage(): string;
}
