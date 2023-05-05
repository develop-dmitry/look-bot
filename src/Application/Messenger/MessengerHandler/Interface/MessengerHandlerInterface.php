<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler\Interface;

use Look\Application\Messenger\MessengerContext\MessengerContextInterface;
use Look\Application\Messenger\MessengerVisual\MessengerVisualInterface;

interface MessengerHandlerInterface
{
    public function handle(MessengerContextInterface $context, MessengerVisualInterface $visual): void;
}
