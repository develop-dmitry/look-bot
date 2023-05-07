<?php

declare(strict_types=1);

namespace Look\Domain\Value\Message\Trait;

use Look\Domain\Value\Message\Interface\MessageInterface;

trait HasMessage
{
    protected MessageInterface $message;

    public function getMessage(): MessageInterface
    {
        return $this->message;
    }

    public function setMessage(MessageInterface $message): static
    {
        $this->message = $message;
        return $this;
    }
}
