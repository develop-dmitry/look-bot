<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Look\Interface;

use Look\Domain\Entity\Clothes\Interface\ClothesInterface;
use Look\Domain\Entity\Hair\Interface\HairInterface;
use Look\Domain\Entity\Makeup\Interface\MakeupInterface;
use Look\Domain\Property\UseId\UseIdInterface;
use Look\Domain\Property\UseName\UseNameInterface;
use Look\Domain\Property\UsePhoto\UsePhotoInterface;
use Look\Domain\Storage\Exception\StorageException;
use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Temperature;

interface LookInterface extends UseIdInterface, UseNameInterface, UsePhotoInterface
{
    /**
     * @return Temperature
     */
    public function getLowerRangeTemperature(): Temperature;

    /**
     * @param int $temperature
     * @return $this
     * @throws InvalidValueException
     */
    public function setLowerRangeTemperature(int $temperature): static;

    /**
     * @return Temperature
     */
    public function getUpperRangeTemperature(): Temperature;

    /**
     * @param int $temperature
     * @return $this
     * @throws InvalidValueException
     */
    public function setUpperRangerTemperature(int $temperature): static;

    /**
     * @return ClothesInterface[]
     * @throws StorageException
     */
    public function getClothes(): array;

    /**
     * @param int ...$clothesPrimaries
     * @return $this
     */
    public function addClothes(int ...$clothesPrimaries): static;

    /**
     * @return HairInterface[]
     * @throws StorageException
     */
    public function getHairs(): array;

    /**
     * @param int ...$hairPrimaries
     * @return $this
     */
    public function addHairs(int ...$hairPrimaries): static;

    /**
     * @return MakeupInterface[]
     * @throws StorageException
     */
    public function getMakeups(): array;

    /**
     * @param int ...$makeupPrimaries
     * @return $this
     */
    public function addMakeups(int ...$makeupPrimaries): static;
}
