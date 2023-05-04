<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Style;

use Look\Domain\Entity\Style\Interface\StyleInterface;
use Look\Domain\Property\UseId\HasId;
use Look\Domain\Property\UseName\HasName;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class Style implements StyleInterface
{
    use HasId, HasName;

    public function __construct(
        protected ValueFactoryInterface $valueFactory
    ) {
    }
}
