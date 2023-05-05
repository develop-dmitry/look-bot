<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerButton;

use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonInterfaceMessenger;
use Look\Application\Messenger\MessengerContainer\Interface\MessengerOptionContainerInterface;
use Look\Application\Messenger\MessengerOption\HasMessengerOption;

abstract class AbstractMessengerButton implements MessengerButtonInterfaceMessenger
{
    use HasMessengerOption;

    protected string $text = '';

    public function __construct(MessengerOptionContainerInterface $optionContainer) {
        $this->setOptionContainer($optionContainer);
    }

    public function setText(string $text): MessengerButtonInterfaceMessenger
    {
        $this->text = $text;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
