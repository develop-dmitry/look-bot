<?php

declare(strict_types=1);

namespace Look\Domain\Value\Factory;

use Look\Domain\Value\Id\Id;
use Look\Domain\Value\Id\Interface\IdInterface;
use Look\Domain\Value\Level\Interface\LevelInterface;
use Look\Domain\Value\Level\Level;
use Look\Domain\Value\Name\Interface\NameInterface;
use Look\Domain\Value\Name\Name;
use Look\Domain\Value\Photo\Interface\PhotoInterface;
use Look\Domain\Value\Photo\Photo;
use Look\Domain\Value\Temperature\Temperature;
use Look\Domain\Value\Temperature\TemperatureInterface;

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
