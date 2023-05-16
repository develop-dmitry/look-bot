<?php

declare(strict_types=1);

namespace Look\Application\Clothes\GetClothesForClient\Interface;

interface GetClothesForClientInterface
{
    public function getClothesForClient(
        GetClothesForClientRequestInterface $request
    ): GetClothesForClientResponseInterface;
}
