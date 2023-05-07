<?php

declare(strict_types=1);

namespace Look\Application\FormatDate;

use DateTimeInterface;

interface FormatDateInterface
{
    public function short(DateTimeInterface $dateTime): string;
}
