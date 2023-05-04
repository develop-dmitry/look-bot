<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Event;

use Look\Domain\Entity\Event\Interface\EventInterface;
use Look\Domain\Property\UseId\HasId;
use Look\Domain\Property\UseName\HasName;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class Event implements EventInterface
{
    use HasId, HasName;

    public function __construct(
        protected ValueFactoryInterface $valueFactory
    ) {
    }
}
