<?php

declare(strict_types=1);

namespace Look\Application\Clothes\ChooseClothes;

use Look\Application\Clothes\ChooseClothes\Interface\ChooseClothesInterface;
use Look\Application\Clothes\ChooseClothes\Interface\ChooseClothesRequestInterface;
use Look\Application\Clothes\ChooseClothes\Interface\ChooseClothesResponseInterface;
use Look\Domain\Clothes\Exception\ClothesNotFoundException;
use Look\Domain\Clothes\Exception\ClothesRepositoryException;
use Look\Domain\Clothes\Interface\ClothesRepositoryInterface;

class ChooseClothesUseCase implements ChooseClothesInterface
{
    public function __construct(
        protected ClothesRepositoryInterface $clothesRepository
    ) {
    }

    public function chooseClothes(ChooseClothesRequestInterface $request): ChooseClothesResponseInterface
    {
        try {
            $clothes = $this->clothesRepository->getClothes($request->getClothesId());
            $this->clothesRepository->chooseClothes($request->getClient(), $clothes);

            return new ChooseClothesResponse(true);
        } catch (ClothesNotFoundException) {
            return new ChooseClothesResponse(false, 'Не удалось найти элемент одежды');
        } catch (ClothesRepositoryException) {
            return new ChooseClothesResponse(false, 'Не удалось выбрать элемент одежды');
        }
    }
}
