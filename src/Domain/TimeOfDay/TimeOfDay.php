<?php

declare(strict_types=1);

namespace Look\Domain\TimeOfDay;

use DateTime;
use Look\Domain\TimeOfDay\Exception\UnexpectedValueException;

class TimeOfDay
{
    public const Afternoon = 'afternoon';

    public const Evening = 'evening';

    public const Night = 'night';

    private function __construct(
        protected string $timeOfDay,
        protected DateTime $date
    ) {
    }

    /**
     * @return array
     */
    public function getHourDiapason(): array
    {
        return match ($this->timeOfDay) {
            self::Afternoon => [9, 10, 11, 12, 13, 14, 15, 16, 17],
            self::Evening => [18, 19, 20, 21, 22, 23],
            self::Night => [0, 1, 2, 3, 4, 5, 6, 7, 8]
        };
    }

    /**
     * @return string
     */
    public function getTimeOfDay(): string
    {
        return $this->timeOfDay;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     * @return self
     */
    public static function fromDateTime(DateTime $date): self
    {
        $hour = (int) $date->format('H');

        if ($hour < 7) {
            return new self(self::Night, $date);
        }

        if ($hour < 16) {
            return new self(self::Afternoon, $date);
        }

        return new self(self::Evening, $date);
    }

    /**
     * @throws UnexpectedValueException
     */
    public static function fromTimeOfDay(string $timeOfDay): self
    {
        $date = match ($timeOfDay) {
            self::Afternoon, self::Evening => new DateTime(),
            self::Night => new DateTime('+1 day'),
            default => throw new UnexpectedValueException("Unexpected value $timeOfDay for time of day")
        };

        return new self($timeOfDay, $date);
    }

    /**
     * @return array
     */
    public static function getValuesList(): array
    {
        return [
            self::Afternoon,
            self::Evening,
            self::Night
        ];
    }
}
