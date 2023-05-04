<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Style\Interface;

use Look\Domain\Property\UseId\UseIdInterface;
use Look\Domain\Property\UseName\UseNameInterface;

interface StyleInterface extends UseIdInterface, UseNameInterface
{
}
