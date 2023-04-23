<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Handler;

use Look\Domain\Messenger\Exception\MessengerHandlerAlreadyExistsException;
use Look\Domain\Messenger\Exception\MessengerHandlerNotFoundException;
use Look\Domain\Messenger\Interface\MessengerHandlerContainerInterface;
use Look\Domain\Messenger\Interface\MessengerHandlerInterface;

class MessengerHandlerContainer implements MessengerHandlerContainerInterface
{
    protected array $handlers = [];

    public function addHandler(
        MessengerHandlerName $name,
        MessengerHandlerType $type,
        MessengerHandlerInterface $handler
    ): void {
        if ($this->hasHandler($name, $type)) {
            throw new MessengerHandlerAlreadyExistsException(
                "Handler for type $type->value and with name $name->value already exists"
            );
        }

        $this->handlers[$type->value][$name->value] = $handler;
    }

    public function getHandler(MessengerHandlerName $name, MessengerHandlerType $type): MessengerHandlerInterface
    {
        if (!$this->hasHandler($name, $type)) {
            throw new MessengerHandlerNotFoundException(
                "Handler for type $type->value and with name $name->value not found"
            );
        }

        return $this->handlers[$type->value][$name->value];
    }

    public function getHandlers(MessengerHandlerType $type): array
    {
        return $this->handlers[$type->value] ?? [];
    }

    public function hasHandler(MessengerHandlerName $name, MessengerHandlerType $type): bool
    {
        return isset($this->handlers[$type->value][$name->value]);
    }
}
