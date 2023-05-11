<?php

declare(strict_types=1);

namespace Look\Application\Clothes\GetClothesForClient;

use Look\Application\Clothes\GetClothesForClient\Interface\GetClothesForClientInterface;
use Look\Application\Clothes\GetClothesForClient\Interface\GetClothesForClientRequestInterface;
use Look\Application\Clothes\GetClothesForClient\Interface\GetClothesForClientResponseInterface;
use Look\Domain\Clothes\Interface\ClothesRepositoryInterface;

class GetClothesForClientUseCase implements GetClothesForClientInterface
{
    public function __construct(
        protected ClothesRepositoryInterface $clothesRepository
    ) {
    }

    public function getClothesForClient(
        GetClothesForClientRequestInterface $request
    ): GetClothesForClientResponseInterface {
        $clothes = $this->clothesRepository->getClothesForUser(
            $request->getClient(),
            $request->getPerPage(),
            $request->getPage()
        );

        return new GetClothesForClientResponse(true, $clothes);
    }
}
