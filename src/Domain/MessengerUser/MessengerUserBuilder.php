<?php

declare(strict_types=1);

namespace Look\Domain\MessengerUser;

use Look\Application\Builder\AbstractBuilder;
use Look\Application\Builder\UseId\HasId;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerName;
use Look\Domain\MessengerUser\Interface\MessengerUserBuilderInterface;
use Look\Domain\MessengerUser\Interface\MessengerUserInterface;
use Look\Domain\Value\Factory\ValueFactoryInterface;

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
            ->setId($this->valueFactory->makeId($this->getValue('id')));

        if ($this->hasValue('messenger_handler')) {
            $messengerHandler = MessengerHandlerName::tryFrom($this->getValue('messenger_handler'));

            if ($messengerHandler) {
                $messengerUser->setMessengerHandler($messengerHandler);
            }
        }

        $this->reset();

        return $messengerUser;
    }
}
