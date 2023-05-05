<?php

declare(strict_types=1);

namespace Look\Application\Client\IdentifyClient\Interface;

use Look\Domain\Client\Interface\ClientInterface;

interface IdentifyClientResponseInterface
{
    /**
     * @return bool
     */
    public function isIdentified(): bool;

    /**
     * @return ClientInterface|null
     */
    public function getClient(): ?ClientInterface;

    /**
     * @return string
     */
    public function getError(): string;
}
