<?php

declare(strict_types=1);

namespace Look\Domain\Client;

use Look\Application\Builder\AbstractBuilder;
use Look\Application\Builder\UseId\HasId;
use Look\Domain\Client\Interface\ClientBuilderInterface;
use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\Value\Factory\ValueFactoryInterface;

class ClientBuilder extends AbstractBuilder implements ClientBuilderInterface
{
    use HasId;

    public function __construct(
        protected ValueFactoryInterface $valueFactory,
    ) {
    }

    public function setTelegramId(?int $telegramId): static
    {
        $this->values['telegram_id'] = $telegramId;
        return $this;
    }

    public function setUserId(?int $userId): static
    {
        $this->values['user_id'] = $userId;
        return $this;
    }

    public function setGeoLocation(?GeoLocationInterface $geoLocation): static
    {
        $this->values['geo_location'] = $geoLocation;
        return $this;
    }

    public function fromArray(array $data): static
    {
        $this->values = array_merge($this->values, $data);
        return $this;
    }

    public function make(): ClientInterface
    {
        $client = new Client();

        if ($this->hasValue('id')) {
            $client->setId($this->valueFactory->makeId($this->getValue('id')));
        }

        if ($this->hasValue('user_id')) {
            $client->setUserId($this->valueFactory->makeId($this->getValue('user_id')));
        }

        if ($this->hasValue('telegram_id')) {
            $client->setTelegramId($this->valueFactory->makeId($this->getValue('telegram_id')));
        }

        if ($this->hasValue('geo_location')) {
            $client->setGeoLocation($this->getValue('geo_location'));
        }

        $this->reset();

        return $client;
    }
}
