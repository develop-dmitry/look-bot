<?php

declare(strict_types=1);

namespace Look\Domain\Value\Message\Interface;

interface UseMessageInterface
{
    /**
     * @return MessageInterface
     */
    public function getMessage(): MessageInterface;

    /**
     * @param MessageInterface $message
     * @return $this
     */
    public function setMessage(MessageInterface $message): static;
}
