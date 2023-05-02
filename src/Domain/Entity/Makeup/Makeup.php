<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Makeup;

use Look\Domain\Entity\Event\Interface\EventRepositoryInterface;
use Look\Domain\Entity\Makeup\Interface\MakeupInterface;
use Look\Domain\Entity\Style\Interface\StyleRepositoryInterface;
use Look\Domain\Property\UseEvent\HasEvent;
use Look\Domain\Property\UseId\HasId;
use Look\Domain\Property\UseLevel\HasLevel;
use Look\Domain\Property\UseName\HasName;
use Look\Domain\Property\UsePhoto\HasPhoto;
use Look\Domain\Property\UseStyle\HasStyle;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class Makeup implements MakeupInterface
{
    use HasId, HasName, HasPhoto, HasLevel, HasStyle, HasEvent;

    public function __construct(
        protected ValueFactoryInterface $valueFactory,
        protected StyleRepositoryInterface $styleRepository,
        protected EventRepositoryInterface $eventRepository
    ) {
    }
}
