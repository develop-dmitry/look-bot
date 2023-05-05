<?php

declare(strict_types=1);

namespace Look\Application\Client\IdentifyClient\Interface;

use Look\Domain\Client\Interface\ClientInterface;

interface IdentifyClientInterface
{
    public function identifyClientFromTelegram(
        IdentifyClientRequestInterface $request
    ): IdentifyClientResponseInterface;
}
