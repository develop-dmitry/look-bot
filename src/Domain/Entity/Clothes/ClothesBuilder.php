<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Clothes;

use Look\Domain\Builder\AbstractBuilder;
use Look\Domain\Builder\UseEvent\HasEvent;
use Look\Domain\Builder\UseId\HasId;
use Look\Domain\Builder\UseName\HasName;
use Look\Domain\Builder\UsePhoto\HasPhoto;
use Look\Domain\Builder\UseStyle\HasStyle;
use Look\Domain\Entity\Clothes\Interface\ClothesBuilderInterface;
use Look\Domain\Entity\Clothes\Interface\ClothesInterface;
use Look\Domain\Entity\Event\Interface\EventRepositoryInterface;
use Look\Domain\Entity\Season\Interface\SeasonRepositoryInterface;
use Look\Domain\Entity\Style\Interface\StyleRepositoryInterface;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class ClothesBuilder extends AbstractBuilder implements ClothesBuilderInterface
{
    use HasId, HasName, HasPhoto, HasStyle, HasEvent;

    protected array $required = ['name', 'photo'];

    public function __construct(
        protected ValueFactoryInterface $valueFactory,
        protected StyleRepositoryInterface $styleRepository,
        protected EventRepositoryInterface $eventRepository,
        protected SeasonRepositoryInterface $seasonRepository
    ) {
    }

    public function addSeasonPrimaries(int ...$seasonPrimaries): static
    {
        $this->values['season_primaries'] = array_merge($this->getValue('season_primaries', []), $seasonPrimaries);
        return $this;
    }

    public function make(): ClothesInterface
    {
        $this->checkRequired();

        $clothes = new Clothes(
            $this->valueFactory,
            $this->styleRepository,
            $this->eventRepository,
            $this->seasonRepository
        );

        $clothes
            ->setId($this->getValue('id'))
            ->setName($this->getValue('name'))
            ->setPhoto($this->getValue('photo'))
            ->addStyles(...$this->getValue('style_primaries', []))
            ->addEvents(...$this->getValue('event_primaries', []))
            ->addSeasons(...$this->getValue('season_primaries', []));

        $this->reset();

        return $clothes;
    }
}
