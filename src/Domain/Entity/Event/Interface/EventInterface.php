<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Event\Interface;

use Look\Domain\Property\UseId\UseIdInterface;
use Look\Domain\Property\UseName\UseNameInterface;

interface EventInterface extends UseIdInterface, UseNameInterface
{
}
