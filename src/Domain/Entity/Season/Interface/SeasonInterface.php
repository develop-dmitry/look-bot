<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Season\Interface;

use Look\Domain\Property\UseId\UseIdInterface;
use Look\Domain\Property\UseName\UseNameInterface;

interface SeasonInterface extends UseIdInterface, UseNameInterface
{
}
