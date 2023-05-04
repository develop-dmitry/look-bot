<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Season;

use Look\Domain\Entity\Season\Interface\SeasonInterface;
use Look\Domain\Property\UseId\HasId;
use Look\Domain\Property\UseName\HasName;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class Season implements SeasonInterface
{
    use HasId, HasName;

    public function __construct(
        protected ValueFactoryInterface $valueFactory
    ) {
    }
}
