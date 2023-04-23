<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Button;

use Look\Domain\Messenger\Interface\ButtonInterface;
use Look\Domain\Messenger\Interface\OptionContainerInterface;
use Look\Domain\Messenger\Option\HasOption;

abstract class AbstractButton implements ButtonInterface
{
    use HasOption;

    protected string $text = '';

    public function __construct(OptionContainerInterface $optionContainer) {
        $this->setOptionContainer($optionContainer);
    }

    public function setText(string $text): ButtonInterface
    {
        $this->text = $text;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
