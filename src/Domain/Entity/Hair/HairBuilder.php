<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Hair;

use Look\Domain\Builder\AbstractBuilder;
use Look\Domain\Builder\UseEvent\HasEvent;
use Look\Domain\Builder\UseId\HasId;
use Look\Domain\Builder\UseLevel\HasLevel;
use Look\Domain\Builder\UseName\HasName;
use Look\Domain\Builder\UsePhoto\HasPhoto;
use Look\Domain\Builder\UseStyle\HasStyle;
use Look\Domain\Entity\Event\Interface\EventRepositoryInterface;
use Look\Domain\Entity\Hair\Interface\HairBuilderInterface;
use Look\Domain\Entity\Hair\Interface\HairInterface;
use Look\Domain\Entity\Style\Interface\StyleRepositoryInterface;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class HairBuilder extends AbstractBuilder implements HairBuilderInterface
{
    use HasId, HasName, HasPhoto, HasLevel, HasStyle, HasEvent;

    protected array $required = ['name', 'photo', 'level'];

    public function __construct(
        protected ValueFactoryInterface $valueFactory,
        protected StyleRepositoryInterface $styleRepository,
        protected EventRepositoryInterface $eventRepository
    ) {
    }

    public function make(): HairInterface
    {
        $this->checkRequired();

        $hair = (new Hair($this->valueFactory, $this->styleRepository, $this->eventRepository))
            ->setId($this->getValue('id'))
            ->setName($this->getValue('name'))
            ->setPhoto($this->getValue('photo'))
            ->setLevel($this->getValue('level'))
            ->addStyles(...$this->getValue('style_primaries', []))
            ->addEvents(...$this->getValue('event_primaries', []));

        $this->reset();

        return $hair;
    }
}
