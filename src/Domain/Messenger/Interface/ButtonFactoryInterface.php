<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

interface ButtonFactoryInterface
{
    public function makeInlineButton(): ButtonInterface;

    public function makeReplyButton(): ButtonInterface;
}
