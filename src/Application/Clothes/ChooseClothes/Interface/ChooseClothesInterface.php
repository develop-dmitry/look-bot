<?php

declare(strict_types=1);

namespace Look\Application\Clothes\ChooseClothes\Interface;

interface ChooseClothesInterface
{
    /**
     * @param ChooseClothesRequestInterface $request
     * @return ChooseClothesResponseInterface
     */
    public function chooseClothes(ChooseClothesRequestInterface $request): ChooseClothesResponseInterface;
}
