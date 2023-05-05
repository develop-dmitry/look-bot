<?php

declare(strict_types=1);

namespace Look\Application\Client\IdentifyClient;

use Look\Application\Client\IdentifyClient\Interface\IdentifyClientRequestInterface;

class IdentifyClientRequest implements IdentifyClientRequestInterface
{
    public function __construct(
        protected int $uid
    ) {
    }

    public function getUid(): int
    {
        return $this->uid;
    }
}
