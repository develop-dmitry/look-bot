<?php

declare(strict_types=1);

namespace Look\Application\Client\SaveClient\Interface;

use Look\Domain\Client\Interface\ClientInterface;

interface SaveClientRequestInterface
{
    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface;
}
