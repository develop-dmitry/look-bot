<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Look\Interface;

use Look\Domain\Builder\Exception\NoRequiredPropertiesException;
use Look\Domain\Builder\UseId\UseIdInterface;
use Look\Domain\Builder\UseName\UseNameInterface;
use Look\Domain\Builder\UsePhoto\UsePhotoInterface;
use Look\Domain\Value\Exception\InvalidValueException;

interface LookBuilderInterface extends UseIdInterface, UseNameInterface, UsePhotoInterface
{
    /**
     * @param int $temperature
     * @return $this
     */
    public function setLowerRangeTemperature(int $temperature): static;

    /**
     * @param int $temperature
     * @return $this
     */
    public function setUpperRangeTemperature(int $temperature): static;

    /**
     * @param int ...$makeupPrimaries
     * @return $this
     */
    public function addMakeupPrimaries(int ...$makeupPrimaries): static;

    /**
     * @param int ...$hairPrimaries
     * @return $this
     */
    public function addHairPrimaries(int ...$hairPrimaries): static;

    /**
     * @param int ...$clothesPrimaries
     * @return $this
     */
    public function addClothesPrimaries(int ...$clothesPrimaries): static;

    /**
     * @return LookInterface
     * @throws InvalidValueException|NoRequiredPropertiesException
     */
    public function make(): LookInterface;
}
