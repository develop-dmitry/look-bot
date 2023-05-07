<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerButton\Interface;

use Look\Application\Messenger\MessengerButton\MessengerButtonType;
use Look\Application\Messenger\MessengerOption\Interface\UseMessengerOptionInterface;

interface MessengerButtonInterface extends UseMessengerOptionInterface
{
    /**
     * @param string $text
     * @return MessengerButtonInterface
     */
    public function setText(string $text): self;

    /**
     * @return string
     */
    public function getText(): string;

    /**
     * @return MessengerButtonType
     */
    public function getType(): MessengerButtonType;
}
