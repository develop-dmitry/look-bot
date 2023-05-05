<?php

declare(strict_types=1);

namespace Look\Application\Messenger;

use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerContainerInterface;

interface MessengerInterface
{
    /**
     * @return void
     */
    public function run(): void;

    /**
     * @param MessengerHandlerContainerInterface $handlers
     * @return void
     */
    public function setHandlerContainer(MessengerHandlerContainerInterface $handlers): void;
}
