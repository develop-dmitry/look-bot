<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerButton;

use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonInterface;
use Look\Application\Messenger\MessengerContainer\Interface\MessengerOptionContainerInterface;
use Look\Application\Messenger\MessengerOption\HasMessengerOption;

abstract class AbstractMessengerButton implements MessengerButtonInterface
{
    use HasMessengerOption;

    protected string $text = '';

    public function __construct(MessengerOptionContainerInterface $optionContainer) {
        $this->setOptionContainer($optionContainer);
    }

    public function setText(string $text): MessengerButtonInterface
    {
        $this->text = $text;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
