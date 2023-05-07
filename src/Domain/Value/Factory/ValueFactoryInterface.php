<?php

declare(strict_types=1);

namespace Look\Domain\Value\Factory;

use Look\Domain\Value\Address\Interface\AddressInterface;
use Look\Domain\Value\Coordinate\Interface\CoordinateInterface;
use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Id\Interface\IdInterface;
use Look\Domain\Value\Level\Interface\LevelInterface;
use Look\Domain\Value\Name\Interface\NameInterface;
use Look\Domain\Value\Photo\Interface\PhotoInterface;
use Look\Domain\Value\Temperature\TemperatureInterface;

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

    /**
     * @param float $coordinate
     * @return CoordinateInterface
     * @throws InvalidValueException
     */
    public function makeCoordinate(float $coordinate): CoordinateInterface;

    /**
     * @param string $address
     * @return AddressInterface
     * @throws InvalidValueException
     */
    public function makeAddress(string $address): AddressInterface;
}
