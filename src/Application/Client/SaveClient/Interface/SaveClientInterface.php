<?php

declare(strict_types=1);

namespace Look\Application\Client\SaveClient\Interface;

interface SaveClientInterface
{
    /**
     * @param SaveClientRequestInterface $request
     * @return SaveClientResponseInterface
     */
    public function saveClient(SaveClientRequestInterface $request): SaveClientResponseInterface;
}
