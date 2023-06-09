<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerVisual;

use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardInterface;
use Look\Domain\Value\Image\Interface\ImageInterface;

interface MessengerVisualInterface
{
    /**
     * @param string $message
     * @param bool $editMessage
     * @return void
     */
    public function sendMessage(string $message, bool $editMessage = false): void;

    /**
     * @param MessengerKeyboardInterface|null $keyboard
     * @return void
     */
    public function sendKeyboard(?MessengerKeyboardInterface $keyboard): void;
}
