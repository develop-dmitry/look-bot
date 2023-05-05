<?php

declare(strict_types=1);

namespace Look\Application\Builder;

use Look\Application\Builder\Exception\NoRequiredPropertiesException;

abstract class AbstractBuilder
{
    protected array $values = [];

    protected array $required = [];

    protected function reset(): void
    {
        $this->values = [];
    }

    protected function hasValue(string $key): bool
    {
        return isset($this->values[$key]) && !is_null($this->values[$key]);
    }

    protected function getValue(string $key, mixed $default = null): mixed
    {
        return ($this->hasValue($key)) ? $this->values[$key] : $default;
    }

    /**
     * @throws NoRequiredPropertiesException
     */
    protected function checkRequired(): void
    {
        foreach ($this->required as $require) {
            if (!$this->hasValue($require)) {
                throw new NoRequiredPropertiesException('Required properties does not exists');
            }
        }
    }
}
