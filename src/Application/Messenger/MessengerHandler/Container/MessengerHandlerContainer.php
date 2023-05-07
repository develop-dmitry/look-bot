<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler\Container;

use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerName;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerType;
use Look\Application\Messenger\MessengerHandler\Exception\MessengerHandlerAlreadyExistsException;
use Look\Application\Messenger\MessengerHandler\Exception\MessengerHandlerNotFoundException;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerContainerInterface;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerInterface;

class MessengerHandlerContainer implements MessengerHandlerContainerInterface
{
    protected array $handlers = [];

    public function addHandler(MessengerHandlerInterface $handler): void
    {
        foreach ($handler->getTypes() as $type) {
            foreach ($handler->getNames() as $name) {
                if ($this->hasHandler($name, $type)) {
                    throw new MessengerHandlerAlreadyExistsException(
                        "Handler for type $type->value and with name $name->value already exists"
                    );
                }

                $this->handlers[$type->value][$name->value] = $handler;
            }
        }
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
