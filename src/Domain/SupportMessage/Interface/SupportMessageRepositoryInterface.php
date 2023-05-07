<?php

declare(strict_types=1);

namespace Look\Domain\SupportMessage\Interface;

use Look\Domain\Exception\RepositoryException;

interface SupportMessageRepositoryInterface
{
    /**
     * @param SupportMessageInterface $supportMessage
     * @return void
     * @throws RepositoryException
     */
    public function createSupportMessage(SupportMessageInterface $supportMessage): void;
}
