<?php

declare(strict_types=1);

namespace Look\Domain\SupportMessage\Interface;

use Look\Application\Builder\Exception\NoRequiredPropertiesException;
use Look\Application\Builder\UseId\UseIdInterface;
use Look\Domain\Value\Exception\InvalidValueException;

interface SupportMessageBuilderInterface extends UseIdInterface
{
    /**
     * @param int $clientId
     * @return self
     */
    public function setClientId(int $clientId): self;

    /**
     * @param string $context
     * @return self
     */
    public function setContext(string $context): self;

    /**
     * @param string $message
     * @return self
     */
    public function setMessage(string $message): self;

    /**
     * @param bool $resolved
     * @return self
     */
    public function setResolved(bool $resolved): self;

    /**
     * @return SupportMessageInterface
     * @throws InvalidValueException|NoRequiredPropertiesException
     */
    public function make(): SupportMessageInterface;
}
