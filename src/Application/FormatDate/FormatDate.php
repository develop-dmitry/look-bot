<?php

declare(strict_types=1);

namespace Look\Application\FormatDate;

use DateTimeInterface;

class FormatDate implements FormatDateInterface
{
    protected array $months = [
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря'
    ];

    public function short(DateTimeInterface $dateTime): string
    {
        $month = (int) $dateTime->format('m');

        return "{$dateTime->format('d')} {$this->months[$month]}";
    }
}
