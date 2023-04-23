<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

use Look\Domain\Messenger\Button\ButtonType;

interface ButtonInterface extends UseOptionInterface
{
    /**
     * @param string $text
     * @return ButtonInterface
     */
    public function setText(string $text): self;

    /**
     * @return string
     */
    public function getText(): string;

    /**
     * @return ButtonType
     */
    public function getType(): ButtonType;
}
