<?php

namespace Look\Domain\Clothes;

use Look\Application\Builder\AbstractBuilder;
use Look\Application\Builder\UseId\HasId;
use Look\Application\Builder\UseName\HasName;
use Look\Application\Builder\UsePhoto\HasPhoto;
use Look\Domain\Clothes\Interface\ClothesBuilderInterface;
use Look\Domain\Clothes\Interface\ClothesInterface;
use Look\Domain\Value\Factory\ValueFactoryInterface;

class ClothesBuilder extends AbstractBuilder implements ClothesBuilderInterface
{
    use HasId, HasPhoto, HasName;

    protected array $required = ['name', 'photo'];

    public function __construct(
        protected ValueFactoryInterface $valueFactory
    ) {
    }

    public function setChosen(bool $isChosen): ClothesBuilderInterface
    {
        $this->values['is_chosen'] = $isChosen;
        return $this;
    }

    public function make(): ClothesInterface
    {
        $this->checkRequired();

        $clothes = (new Clothes())
            ->setName($this->valueFactory->makeName($this->getValue('name', '')))
            ->setPhoto($this->valueFactory->makePhoto($this->getValue('photo', '')))
            ->setChosen($this->getValue('is_chosen', false));

        if ($this->hasValue('id')) {
            $clothes->setId($this->valueFactory->makeId($this->getValue('id')));
        }

        $this->reset();

        return $clothes;
    }

}
