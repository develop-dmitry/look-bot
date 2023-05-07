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

    protected string $timeOfDay;

    protected DateTime $date;

    private function __construct()
    {
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

    public function equal(TimeOfDay $timeOfDay): bool
    {
        return $this->timeOfDay === $timeOfDay->getTimeOfDay()
            && $this->date->format('Y-m-d') === $timeOfDay->getDate()->format('Y-m-d');
    }

    /**
     * @return TimeOfDay[]
     */
    public function getNexts(): array
    {
        try {
            return match ($this->timeOfDay) {
                self::Afternoon => [self::fromTimeOfDay(self::Evening), self::fromTimeOfDay(self::Night)],
                self::Evening => [self::fromTimeOfDay(self::Night)],
                default => []
            };
        } catch (UnexpectedValueException) {
            return [];
        }
    }

    public function isTomorrow(): bool
    {
        $tomorrow = new DateTime('tomorrow');

        return $tomorrow->format('Y-m-d') === $this->date->format('Y-m-d');
    }

    public function isToday(): bool
    {
        $today = new DateTime();

        return $today->format('Y-m-d') === $this->date->format('Y-m-d');
    }

    /**
     * @param DateTime $date
     * @return self
     */
    public static function fromDateTime(DateTime $date): self
    {
        $hour = (int) $date->format('H');

        if ($hour < 7) {
            return self::make(self::Night, $date);
        }

        if ($hour < 16) {
            return self::make(self::Afternoon, $date);
        }

        return self::make(self::Evening, $date);
    }

    /**
     * @throws UnexpectedValueException
     */
    public static function fromTimeOfDay(string $timeOfDay): self
    {
        return match ($timeOfDay) {
            self::Afternoon => self::make(self::Afternoon, new DateTime()),
            self::Evening => self::make(self::Evening, new DateTime()),
            self::Night => self::make(self::Night, new DateTime('tomorrow')),
            default => throw new UnexpectedValueException("Unexpected value $timeOfDay for time of day")
        };
    }

    protected static function make(string $value, DateTime $date): self
    {
        $timeOfDay = new self();

        $timeOfDay->timeOfDay = $value;
        $hoursDiapasons = $timeOfDay->getHourDiapason();

        if (!empty($hoursDiapasons)) {
            $date->setTime($hoursDiapasons[0], 0);
        }

        $timeOfDay->date = $date;

        return $timeOfDay;
    }
}
