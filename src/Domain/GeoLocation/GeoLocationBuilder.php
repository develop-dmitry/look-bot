<?php

declare(strict_types=1);

namespace Look\Domain\GeoLocation;

use Look\Application\Builder\AbstractBuilder;
use Look\Domain\GeoLocation\Interface\GeoLocationBuilderInterface;
use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\Value\Factory\ValueFactoryInterface;

class GeoLocationBuilder extends AbstractBuilder implements GeoLocationBuilderInterface
{
    protected array $required = ['lat', 'lon'];

    public function __construct(
        protected ValueFactoryInterface $valueFactory
    ) {
    }

    public function setLat(float $coordinate): GeoLocationBuilderInterface
    {
        $this->values['lat'] = $coordinate;
        return $this;
    }

    public function setLon(float $coordinate): GeoLocationBuilderInterface
    {
        $this->values['lon'] = $coordinate;
        return $this;
    }

    public function setAddress(string $address): GeoLocationBuilderInterface
    {
        $this->values['address'] = $address;
        return $this;
    }

    public function make(): GeoLocationInterface
    {
        $this->checkRequired();

        $geoPosition = (new GeoLocation())
            ->setLon($this->valueFactory->makeCoordinate($this->getValue('lon')))
            ->setLat($this->valueFactory->makeCoordinate($this->getValue('lat')));

        if ($this->hasValue('address')) {
            $geoPosition->setAddress($this->valueFactory->makeAddress($this->getValue('address', '')));
        }

        $this->reset();

        return $geoPosition;
    }
}
