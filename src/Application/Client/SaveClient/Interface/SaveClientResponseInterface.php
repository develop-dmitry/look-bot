<?php

declare(strict_types=1);

namespace Look\Application\Client\SaveClient\Interface;

interface SaveClientResponseInterface
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
