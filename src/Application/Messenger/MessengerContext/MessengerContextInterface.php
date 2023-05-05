<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerContext;

use Look\Application\Messenger\MessengerRequest\Interface\MessengerRequestInterface;
use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\MessengerUser\Interface\MessengerUserInterface;

interface MessengerContextInterface
{
    /**
     * @return MessengerRequestInterface
     */
    public function getRequest(): MessengerRequestInterface;

    /**
     * @return ClientInterface|null
     */
    public function getClient(): ?ClientInterface;

    /**
     * @return MessengerUserInterface|null
     */
    public function getMessengerUser(): ?MessengerUserInterface;

    /**
     * @return bool
     */
    public function isIdentifiedClient(): bool;

    /**
     * @return bool
     */
    public function isIdentifiedMessengerUser(): bool;
}
