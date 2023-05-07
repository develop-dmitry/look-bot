<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerRequest;

use Look\Application\Messenger\MessengerRequest\Interface\MessengerRequestInterface;
use Look\Domain\GeoLocation\Interface\GeoLocationInterface;

class MessengerRequest implements MessengerRequestInterface
{
    protected string $message = '';

    protected array $callbackQuery = [];

    protected ?GeoLocationInterface $geoLocation = null;

    public function setMessage(string $message): MessengerRequestInterface
    {
        $this->message = $message;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setCallbackQuery(array $callbackQuery): MessengerRequestInterface
    {
        $this->callbackQuery = $callbackQuery;
        return $this;
    }

    public function getCallbackQuery(): array
    {
        return $this->callbackQuery;
    }

    public function setGeoLocation(?GeoLocationInterface $geoLocation): MessengerRequestInterface
    {
        $this->geoLocation = $geoLocation;
        return $this;
    }

    public function getGeoLocation(): ?GeoLocationInterface
    {
        return $this->geoLocation;
    }
}
