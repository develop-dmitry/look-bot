<?php

declare(strict_types=1);

namespace Look\Domain\Client;

use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\Value\Id\Id;
use Look\Domain\Value\Id\Interface\IdInterface;
use Look\Domain\Value\Id\Trait\HasId;

class Client implements ClientInterface
{
    use HasId;

    protected ?Id $telegramId = null;

    protected ?Id $userId = null;

    protected ?GeoLocationInterface $geoLocation = null;

    public function setTelegramId(?IdInterface $telegramId): ClientInterface
    {
        $this->telegramId = $telegramId;
        return $this;
    }

    public function setUserId(?IdInterface $userId): ClientInterface
    {
        $this->userId = $userId;
        return $this;
    }

    public function getTelegramId(): ?Id
    {
        return $this->telegramId;
    }

    public function getUserId(): ?Id
    {
        return $this->userId;
    }

    public function setGeoLocation(?GeoLocationInterface $geoPosition): ClientInterface
    {
        $this->geoLocation = $geoPosition;
        return $this;
    }

    public function getGeoLocation(): ?GeoLocationInterface
    {
        return $this->geoLocation;
    }
}
