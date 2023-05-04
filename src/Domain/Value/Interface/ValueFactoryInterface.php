<?php

declare(strict_types=1);

namespace Look\Domain\Value\Interface;

use Look\Domain\Value\Exception\InvalidValueException;

interface ValueFactoryInterface
{
    /**
     * @param int $value
     * @return IdInterface
     * @throws InvalidValueException
     */
    public function makeId(int $value): IdInterface;

    /**
     * @param string $name
     * @return NameInterface
     * @throws InvalidValueException
     */
    public function makeName(string $name): NameInterface;

    /**
     * @param string $photo
     * @return PhotoInterface
     * @throws InvalidValueException
     */
    public function makePhoto(string $photo): PhotoInterface;

    /**
     * @param int $level
     * @return LevelInterface
     * @throws InvalidValueException
     */
    public function makeLevel(int $level): LevelInterface;

    /**
     * @param int $temperature
     * @return TemperatureInterface
     * @throws InvalidValueException
     */
    public function makeTemperature(int $temperature): TemperatureInterface;
}
