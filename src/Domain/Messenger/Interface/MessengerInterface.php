<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

use Look\Domain\Messenger\Exception\FailedSetNextMessageHandlerException;
use Look\Domain\Messenger\Handler\MessengerHandlerName;

interface MessengerInterface
{
    /**
     * @return void
     */
    public function run(): void;

    /**
     * @param string $message
     * @param bool $editMessage
     * @return void
     */
    public function sendMessage(string $message, bool $editMessage = false): void;

    /**
     * @param KeyboardInterface $keyboard
     * @return void
     */
    public function sendKeyboard(KeyboardInterface $keyboard): void;

    /**
     * @return void
     */
    public function sendTechnicalErrorMessage(): void;

    /**
     * @param MessengerHandlerContainerInterface $handlers
     * @return void
     */
    public function setHandlerContainer(MessengerHandlerContainerInterface $handlers): void;

    /**
     * @param MessengerHandlerName $handlerName
     * @return void
     * @throws FailedSetNextMessageHandlerException
     */
    public function setNextMessageHandler(MessengerHandlerName $handlerName): void;
}
