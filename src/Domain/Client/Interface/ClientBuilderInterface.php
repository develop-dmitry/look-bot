<?php

declare(strict_types=1);

namespace Look\Domain\Client\Interface;

use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\Value\Exception\InvalidValueException;

interface ClientBuilderInterface
{
    /**
     * @param int|null $id
     * @return static
     */
    public function setId(?int $id): static;

    /**
     * @param int|null $telegramId
     * @return static
     */
    public function setTelegramId(?int $telegramId): static;

    /**
     * @param int|null $userId
     * @return static
     */
    public function setUserId(?int $userId): static;

    /**
     * @param GeoLocationInterface|null $geoLocation
     * @return $this
     */
    public function setGeoLocation(?GeoLocationInterface $geoLocation): static;

    /**
     * @param array $data
     * @return static
     */
    public function fromArray(array $data): static;

    /**
     * @return ClientInterface
     * @throws InvalidValueException
     */
    public function make(): ClientInterface;
}
