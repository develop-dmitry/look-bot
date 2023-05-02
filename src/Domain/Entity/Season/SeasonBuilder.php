<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Season;

use Look\Domain\Builder\AbstractBuilder;
use Look\Domain\Builder\UseId\HasId;
use Look\Domain\Builder\UseName\HasName;
use Look\Domain\Entity\Season\Interface\SeasonBuilderInterface;
use Look\Domain\Entity\Season\Interface\SeasonInterface;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class SeasonBuilder extends AbstractBuilder implements SeasonBuilderInterface
{
    use HasId, HasName;

    protected array $required = ['name'];

    public function __construct(
        protected ValueFactoryInterface $valueFactory
    ) {
    }

    public function make(): SeasonInterface
    {
        $this->checkRequired();

        $season = (new Season($this->valueFactory))
            ->setId($this->getValue('id'))
            ->setName($this->getValue('name'));

        $this->reset();

        return $season;
    }
}
