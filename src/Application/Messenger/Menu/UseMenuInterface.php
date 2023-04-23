<?php

declare(strict_types=1);

namespace Look\Application\Messenger\Menu;

use Look\Domain\Messenger\Interface\KeyboardInterface;

interface UseMenuInterface
{
    /**
     * @return KeyboardInterface
     * @throws FailedBuildMenuException
     */
    public function getMenuKeyboard(): KeyboardInterface;
}
