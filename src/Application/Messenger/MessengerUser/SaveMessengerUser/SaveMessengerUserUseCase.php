<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerUser\SaveMessengerUser;

use Look\Application\Messenger\MessengerUser\SaveMessengerUser\Interface\SaveMessengerUserInterface;
use Look\Application\Messenger\MessengerUser\SaveMessengerUser\Interface\SaveMessengerUserRequestInterface;
use Look\Application\Messenger\MessengerUser\SaveMessengerUser\Interface\SaveMessengerUserResponseInterface;
use Look\Domain\Exception\RepositoryException;
use Look\Domain\MessengerUser\Interface\MessengerUserRepositoryInterface;
use Psr\Log\LoggerInterface;

class SaveMessengerUserUseCase implements SaveMessengerUserInterface
{
    public function __construct(
        protected MessengerUserRepositoryInterface $messengerUserRepository,
        protected LoggerInterface $logger
    ) {
    }

    public function saveMessengerUser(SaveMessengerUserRequestInterface $request): SaveMessengerUserResponseInterface
    {
        try {
            $success = $this->messengerUserRepository->saveMessengerUser($request->getMessengerUser());

            return new SaveMessengerUserResponse($success);
        } catch (RepositoryException $exception) {
            $this->logger->emergency('Не удалось сохранить пользователя мессенджера', [
                'request' => $request,
                'exception' => $exception
            ]);

            return new SaveMessengerUserResponse(false, 'Не удалось сохранить пользователя мессенджера');
        }
    }
}
