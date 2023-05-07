<?php

declare(strict_types=1);

namespace Look\Application\Client\SaveClient;

use Look\Application\Client\SaveClient\Interface\SaveClientInterface;
use Look\Application\Client\SaveClient\Interface\SaveClientRequestInterface;
use Look\Application\Client\SaveClient\Interface\SaveClientResponseInterface;
use Look\Domain\Client\Exception\ClientNotFoundException;
use Look\Domain\Client\Interface\ClientRepositoryInterface;
use Look\Domain\Exception\RepositoryException;

class SaveClientUseCase implements SaveClientInterface
{
    public function __construct(
        protected ClientRepositoryInterface $clientRepository
    ) {
    }

    public function saveClient(SaveClientRequestInterface $request): SaveClientResponseInterface
    {
        try {
            $this->clientRepository->saveClient($request->getClient());

            return new SaveClientResponse(true);
        } catch (ClientNotFoundException) {
            return new SaveClientResponse(false, 'Не удалось найти клиента');
        } catch (RepositoryException) {
            return new SaveClientResponse(false, 'Произошла ошибка, попробуйте позднее');
        }
    }

}
