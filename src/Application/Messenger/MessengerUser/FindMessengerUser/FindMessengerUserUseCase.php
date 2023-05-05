<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerUser\FindMessengerUser;

use Look\Application\Messenger\MessengerUser\FindMessengerUser\Interface\FindMessengerUserInterface;
use Look\Application\Messenger\MessengerUser\FindMessengerUser\Interface\FindMessengerUserRequestInterface;
use Look\Application\Messenger\MessengerUser\FindMessengerUser\Interface\FindMessengerUserResponseInterface;
use Look\Domain\Exception\RepositoryException;
use Look\Domain\MessengerUser\Exception\MessengerUserNotFoundException;
use Look\Domain\MessengerUser\Interface\MessengerUserRepositoryInterface;
use Look\Domain\Value\Exception\InvalidValueException;
use Psr\Log\LoggerInterface;

class FindMessengerUserUseCase implements FindMessengerUserInterface
{
    public function __construct(
        protected MessengerUserRepositoryInterface $messengerUserRepository,
        protected LoggerInterface $logger
    ) {
    }

    public function findMessengerUser(FindMessengerUserRequestInterface $request): FindMessengerUserResponseInterface
    {
        try {
            $messengerUser = $this->messengerUserRepository->getMessengerUserById($request->getMessengerUserUid());

            return new FindMessengerUserResponse(true, '', $messengerUser);
        } catch (RepositoryException|InvalidValueException $exception) {
            $this->logger->emergency('Не удалось найти пользователя мессенджера', [
                'request' => $request,
                'exception' => $exception
            ]);

            return new FindMessengerUserResponse(false, 'Технические неполадки, попробуйте позднее');
        } catch (MessengerUserNotFoundException $exception) {
            return new FindMessengerUserResponse(false, 'Не удалось найти пользователя мессенджера');
        }
    }
}
