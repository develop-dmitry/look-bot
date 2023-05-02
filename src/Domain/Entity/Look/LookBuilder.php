<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Look;

use Look\Domain\Builder\AbstractBuilder;
use Look\Domain\Builder\UseId\HasId;
use Look\Domain\Builder\UseName\HasName;
use Look\Domain\Builder\UsePhoto\HasPhoto;
use Look\Domain\Entity\Clothes\Interface\ClothesRepositoryInterface;
use Look\Domain\Entity\Hair\Interface\HairRepositoryInterface;
use Look\Domain\Entity\Look\Interface\LookBuilderInterface;
use Look\Domain\Entity\Look\Interface\LookInterface;
use Look\Domain\Entity\Makeup\Interface\MakeupRepositoryInterface;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class LookBuilder extends AbstractBuilder implements LookBuilderInterface
{
    use HasId, HasName, HasPhoto;

    protected array $required = ['name', 'photo', 'lower_range_temperature', 'upper_range_temperature'];

    public function __construct(
        protected ValueFactoryInterface $valueFactory,
        protected HairRepositoryInterface $hairRepository,
        protected ClothesRepositoryInterface $clothesRepository,
        protected MakeupRepositoryInterface $makeupRepository
    ) {
    }

    public function setLowerRangeTemperature(int $temperature): static
    {
        $this->values['lower_range_temperature'] = $temperature;
        return $this;
    }

    public function setUpperRangeTemperature(int $temperature): static
    {
        $this->values['upper_range_temperature'] = $temperature;
        return $this;
    }

    public function addMakeupPrimaries(int ...$makeupPrimaries): static
    {
        $this->values['makeup_primaries'] = array_merge($this->getValue('makeup_primaries', []), $makeupPrimaries);
        return $this;
    }

    public function addHairPrimaries(int ...$hairPrimaries): static
    {
        $this->values['hair_primaries'] = array_merge($this->getValue('hair_primaries', []), $hairPrimaries);
        return $this;
    }

    public function addClothesPrimaries(int ...$clothesPrimaries): static
    {
        $this->values['clothes_primaries'] = array_merge(
            $this->getValue('clothes_primaries', []),
            $clothesPrimaries
        );

        return $this;
    }

    public function make(): LookInterface
    {
        $this->checkRequired();

        $look = new Look(
            $this->valueFactory,
            $this->hairRepository,
            $this->makeupRepository,
            $this->clothesRepository
        );

        $look
            ->setId($this->getValue('id'))
            ->setName($this->getValue('name'))
            ->setPhoto($this->getValue('photo'))
            ->setLowerRangeTemperature($this->getValue('lower_range_temperature'))
            ->setUpperRangerTemperature($this->getValue('upper_range_temperature'))
            ->addHairs(...$this->getValue('hair_primaries', []))
            ->addMakeups(...$this->getValue('makeup_primaries', []))
            ->addClothes(...$this->getValue('clothes_primaries', []));

        $this->reset();

        return $look;
    }
}
