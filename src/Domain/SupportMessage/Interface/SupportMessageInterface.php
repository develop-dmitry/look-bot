<?php

declare(strict_types=1);

namespace Look\Domain\SupportMessage\Interface;

use Look\Domain\Value\Id\Id;
use Look\Domain\Value\Id\Interface\UseIdInterface;
use Look\Domain\Value\Message\Interface\MessageInterface;
use Look\Domain\Value\Message\Interface\UseMessageInterface;

interface SupportMessageInterface extends UseIdInterface, UseMessageInterface
{
    /**
     * @return Id
     */
    public function getClientId(): Id;

    /**
     * @param Id $clientId
     * @return SupportMessageInterface
     */
    public function setClientId(Id $clientId): self;

    /**
     * @return string
     */
    public function getContext(): string;

    /**
     * @param string $context
     * @return SupportMessageInterface
     */
    public function setContext(string $context): self;

    /**
     * @return bool
     */
    public function isResolved(): bool;

    /**
     * @param bool $resolved
     * @return SupportMessageInterface
     */
    public function setResolved(bool $resolved): self;
}
