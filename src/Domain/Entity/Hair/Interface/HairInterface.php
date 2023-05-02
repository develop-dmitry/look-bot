<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Hair\Interface;

use Look\Domain\Property\UseEvent\UseEventInterface;
use Look\Domain\Property\UseId\UseIdInterface;
use Look\Domain\Property\UseLevel\UseLevelInterface;
use Look\Domain\Property\UseName\UseNameInterface;
use Look\Domain\Property\UsePhoto\UsePhotoInterface;
use Look\Domain\Property\UseStyle\UseStyleInterface;

interface HairInterface extends
    UseIdInterface,
    UseNameInterface,
    UsePhotoInterface,
    UseLevelInterface,
    UseStyleInterface,
    UseEventInterface
{
}
