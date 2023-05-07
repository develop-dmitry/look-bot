<?php

declare(strict_types=1);

namespace Look\Application\SupportMessage\CreateSupportMessage\Interface;

interface CreateSupportMessageInterface
{
    public function createSupportMessage(
        CreateSupportMessageRequestInterface $request
    ): CreateSupportMessageResponseInterface;
}
