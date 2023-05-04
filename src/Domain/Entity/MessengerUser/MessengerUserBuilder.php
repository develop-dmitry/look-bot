<?php

declare(strict_types=1);

namespace Look\Domain\Entity\MessengerUser;

use Look\Domain\Builder\AbstractBuilder;
use Look\Domain\Builder\UseId\HasId;
use Look\Domain\Entity\MessengerUser\Interface\MessengerUserBuilderInterface;
use Look\Domain\Entity\MessengerUser\Interface\MessengerUserInterface;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class MessengerUserBuilder extends AbstractBuilder implements MessengerUserBuilderInterface
{
    use HasId;

    protected array $required = ['id'];

    public function __construct(
        protected ValueFactoryInterface $valueFactory
    ) {
    }

    public function setMessengerHandler(?string $handler): MessengerUserBuilderInterface
    {
        $this->values['messenger_handler'] = $handler;
        return $this;
    }

    public function make(): MessengerUserInterface
    {
        $this->checkRequired();

        $messengerUser = (new MessengerUser($this->valueFactory))
            ->setId($this->getValue('id'))
            ->setMessengerHandler($this->getValue('messenger_handler'));

        $this->reset();

        return $messengerUser;
    }
}
