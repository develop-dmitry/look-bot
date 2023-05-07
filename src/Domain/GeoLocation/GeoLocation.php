<?php

declare(strict_types=1);

namespace Look\Domain\GeoLocation;

use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\Value\Address\Interface\AddressInterface;
use Look\Domain\Value\Coordinate\Interface\CoordinateInterface;

class GeoLocation implements GeoLocationInterface
{
    protected CoordinateInterface $lat;

    protected CoordinateInterface $lon;

    protected ?AddressInterface $address = null;

    public function getLat(): CoordinateInterface
    {
        return $this->lat;
    }

    public function setLat(CoordinateInterface $coordinate): GeoLocationInterface
    {
        $this->lat = $coordinate;
        return $this;
    }

    public function getLon(): CoordinateInterface
    {
        return $this->lon;
    }

    public function setLon(CoordinateInterface $coordinate): GeoLocationInterface
    {
        $this->lon = $coordinate;
        return $this;
    }

    public function setAddress(AddressInterface $address): GeoLocationInterface
    {
        $this->address = $address;
        return $this;
    }

    public function getAddress(): ?AddressInterface
    {
        return $this->address;
    }
}
