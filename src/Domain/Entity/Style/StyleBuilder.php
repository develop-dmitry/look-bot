<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Style;

use Look\Domain\Builder\AbstractBuilder;
use Look\Domain\Builder\UseId\HasId;
use Look\Domain\Builder\UseName\HasName;
use Look\Domain\Entity\Style\Interface\StyleBuilderInterface;
use Look\Domain\Entity\Style\Interface\StyleInterface;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class StyleBuilder extends AbstractBuilder implements StyleBuilderInterface
{
    use HasId, HasName;

    protected array $required = ['name'];

    public function __construct(
        protected ValueFactoryInterface $valueFactory
    ) {
    }

    public function make(): StyleInterface
    {
        $this->checkRequired();

        $style = (new Style($this->valueFactory))
            ->setId($this->getValue('id'))
            ->setName($this->getValue('name'));

        $this->reset();

        return $style;
    }
}
