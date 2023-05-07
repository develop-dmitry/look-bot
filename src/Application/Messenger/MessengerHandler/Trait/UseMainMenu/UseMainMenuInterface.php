<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler\Trait\UseMainMenu;

use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardInterface;

interface UseMainMenuInterface
{
    /**
     * @return MessengerKeyboardInterface|null
     */
    public function getMainMenuKeyboard(): ?MessengerKeyboardInterface;
}
