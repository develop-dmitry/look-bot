<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler\Trait\Menu;

use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardInterface;

interface UseMenuInterface
{
    /**
     * @return MessengerKeyboardInterface
     * @throws FailedBuildMenuException
     */
    public function getMenuKeyboard(): MessengerKeyboardInterface;
}
