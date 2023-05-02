<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Event;

use Look\Domain\Builder\AbstractBuilder;
use Look\Domain\Builder\UseId\HasId;
use Look\Domain\Builder\UseName\HasName;
use Look\Domain\Entity\Event\Interface\EventBuilderInterface;
use Look\Domain\Entity\Event\Interface\EventInterface;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class EventBuilder extends AbstractBuilder implements EventBuilderInterface
{
    use HasId, HasName;

    protected array $required = ['name'];

    public function __construct(
        protected ValueFactoryInterface $valueFactory
    ) {
    }

    public function make(): EventInterface
    {
        $this->checkRequired();

        $event = (new Event($this->valueFactory))
            ->setId($this->getValue('id'))
            ->setName($this->getValue('name'));

        $this->reset();

        return $event;
    }
}
