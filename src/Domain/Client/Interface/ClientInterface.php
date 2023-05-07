<?php

declare(strict_types=1);

namespace Look\Domain\Client\Interface;

use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Id\Id;
use Look\Domain\Value\Id\Interface\IdInterface;
use Look\Domain\Value\Id\Interface\UseIdInterface;

interface ClientInterface extends UseIdInterface
{
    /**
     * @param IdInterface|null $telegramId
     * @return self
     * @throws InvalidValueException
     */
    public function setTelegramId(?IdInterface $telegramId): self;

    /**
     * @param IdInterface|null $userId
     * @return self
     * @throws InvalidValueException
     */
    public function setUserId(?IdInterface $userId): self;

    /**
     * @return Id|null
     */
    public function getTelegramId(): ?Id;

    /**
     * @return Id|null
     */
    public function getUserId(): ?Id;

    /**
     * @param GeoLocationInterface|null $geoPosition
     * @return self
     */
    public function setGeoLocation(?GeoLocationInterface $geoPosition): self;

    /**
     * @return GeoLocationInterface|null
     */
    public function getGeoLocation(): ?GeoLocationInterface;
}
