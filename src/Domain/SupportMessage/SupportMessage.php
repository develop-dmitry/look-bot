<?php

declare(strict_types=1);

namespace Look\Domain\SupportMessage;

use Look\Domain\SupportMessage\Interface\SupportMessageInterface;
use Look\Domain\Value\Id\Id;
use Look\Domain\Value\Id\Trait\HasId;
use Look\Domain\Value\Message\Interface\MessageInterface;
use Look\Domain\Value\Message\Trait\HasMessage;

class SupportMessage implements SupportMessageInterface
{
    use HasId, HasMessage;

    protected Id $clientId;

    protected string $context;

    protected bool $resolved;

    protected ?MessageInterface $comment = null;

    public function getClientId(): Id
    {
        return $this->clientId;
    }

    public function setClientId(Id $clientId): SupportMessageInterface
    {
        $this->clientId = $clientId;
        return $this;
    }

    public function getContext(): string
    {
        return $this->context;
    }

    public function setContext(string $context): SupportMessageInterface
    {
        $this->context = $context;
        return $this;
    }

    public function isResolved(): bool
    {
        return $this->resolved;
    }

    public function setResolved(bool $resolved): SupportMessageInterface
    {
        $this->resolved = $resolved;
        return $this;
    }
}
