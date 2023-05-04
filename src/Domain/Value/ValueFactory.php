<?php

declare(strict_types=1);

namespace Look\Domain\Value;

use Look\Domain\Value\Interface\IdInterface;
use Look\Domain\Value\Interface\LevelInterface;
use Look\Domain\Value\Interface\NameInterface;
use Look\Domain\Value\Interface\PhotoInterface;
use Look\Domain\Value\Interface\TemperatureInterface;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class ValueFactory implements ValueFactoryInterface
{
    public function makeId(int $value): IdInterface
    {
        return new Id($value);
    }

    public function makeName(string $name): NameInterface
    {
        return new Name($name);
    }

    public function makePhoto(string $photo): PhotoInterface
    {
        return new Photo($photo);
    }

    public function makeLevel(int $level): LevelInterface
    {
        return new Level($level);
    }

    public function makeTemperature(int $temperature): TemperatureInterface
    {
        return new Temperature($temperature);
    }
}
