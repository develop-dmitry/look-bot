<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Look;

use Look\Domain\Entity\Clothes\Interface\ClothesInterface;
use Look\Domain\Entity\Clothes\Interface\ClothesRepositoryInterface;
use Look\Domain\Entity\Hair\Interface\HairInterface;
use Look\Domain\Entity\Hair\Interface\HairRepositoryInterface;
use Look\Domain\Entity\Look\Interface\LookInterface;
use Look\Domain\Entity\Makeup\Interface\MakeupInterface;
use Look\Domain\Entity\Makeup\Interface\MakeupRepositoryInterface;
use Look\Domain\Property\UseId\HasId;
use Look\Domain\Property\UseName\HasName;
use Look\Domain\Property\UsePhoto\HasPhoto;
use Look\Domain\Value\Interface\TemperatureInterface;
use Look\Domain\Value\Interface\ValueFactoryInterface;
use Look\Domain\Value\Temperature;

class Look implements LookInterface
{
    use HasId, HasName, HasPhoto;

    protected TemperatureInterface $lowerRangeTemperature;

    protected TemperatureInterface $upperRangeTemperature;

    /**
     * @var ClothesInterface[]
     */
    protected array $clothes = [];

    /**
     * @var MakeupInterface[]
     */
    protected array $makeups = [];

    /**
     * @var HairInterface[]
     */
    protected array $hairs = [];

    protected array $getHairsQueue = [];

    protected array $getMakeupsQueue = [];

    protected array $getClothesQueue = [];

    public function __construct(
        protected ValueFactoryInterface $valueFactory,
        protected HairRepositoryInterface $hairRepository,
        protected MakeupRepositoryInterface $makeupRepository,
        protected ClothesRepositoryInterface $clothesRepository
    ) {
    }

    public function getLowerRangeTemperature(): Temperature
    {
        return $this->lowerRangeTemperature;
    }

    public function setLowerRangeTemperature(int $temperature): static
    {
        $this->lowerRangeTemperature = $this->valueFactory->makeTemperature($temperature);
        return $this;
    }

    public function getUpperRangeTemperature(): Temperature
    {
        return $this->upperRangeTemperature;
    }

    public function setUpperRangerTemperature(int $temperature): static
    {
        $this->upperRangeTemperature = $this->valueFactory->makeTemperature($temperature);
        return $this;
    }

    public function getClothes(): array
    {
        if (!empty($this->getClothesQueue)) {
            foreach ($this->clothesRepository->getItemsById($this->getClothesQueue) as $clothes) {
                $this->clothes[] = $clothes;
            }

            $this->getClothesQueue = [];
        }

        return $this->clothes;
    }

    public function addClothes(int ...$clothesPrimaries): static
    {
        $this->getClothesQueue = array_merge($this->getClothesQueue, $clothesPrimaries);
        return $this;
    }

    public function getHairs(): array
    {
        if (!empty($this->getHairsQueue)) {
            foreach ($this->hairRepository->getItemsById($this->getHairsQueue) as $hair) {
                $this->hairs[] = $hair;
            }

            $this->getHairsQueue = [];
        }

        return $this->hairs;
    }

    public function addHairs(int ...$hairPrimaries): static
    {
        $this->getHairsQueue = array_merge($this->getHairsQueue, $hairPrimaries);
        return $this;
    }

    public function getMakeups(): array
    {
        if (!empty($this->getMakeupsQueue)) {
            foreach ($this->makeupRepository->getItemsById($this->getMakeupsQueue) as $makeup) {
                $this->makeups[] = $makeup;
            }

            $this->getMakeupsQueue = [];
        }

        return $this->makeups;
    }

    public function addMakeups(int ...$makeupPrimaries): static
    {
        $this->getMakeupsQueue = array_merge($this->getMakeupsQueue, $makeupPrimaries);
        return $this;
    }
}
