<?php

declare(strict_types=1);

namespace Look\Application\Client\IdentifyClient\Interface;

interface IdentifyClientRequestInterface
{
    /**
     * @return int
     */
    public function getUid(): int;
}
