<?php

declare(strict_types=1);

namespace Look\Domain\GeoLocation\Interface;

use Look\Domain\Value\Address\Interface\AddressInterface;
use Look\Domain\Value\Coordinate\Interface\CoordinateInterface;

interface GeoLocationInterface
{
    /**
     * @return CoordinateInterface
     */
    public function getLat(): CoordinateInterface;

    /**
     * @param CoordinateInterface $coordinate
     * @return self
     */
    public function setLat(CoordinateInterface $coordinate): self;

    /**
     * @return CoordinateInterface
     */
    public function getLon(): CoordinateInterface;

    /**
     * @param CoordinateInterface $coordinate
     * @return self
     */
    public function setLon(CoordinateInterface $coordinate): self;

    /**
     * @param AddressInterface $address
     * @return self
     */
    public function setAddress(AddressInterface $address): self;

    /**
     * @return AddressInterface|null
     */
    public function getAddress(): ?AddressInterface;
}
