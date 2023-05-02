<?php

declare(strict_types=1);

namespace Look\Application\Client;

use Look\Application\Client\Request\ClientByTelegramRequest;
use Look\Domain\Entity\Client\Client;
use Look\Domain\Entity\Client\Exception\ClientNotFoundException;
use Look\Domain\Entity\Client\Interface\ClientBuilderInterface;
use Look\Domain\Entity\Client\Interface\ClientRepositoryInterface;

class TelegramClientUseCase implements ClientUseCaseInterface
{
    public function __construct(
        protected ClientRepositoryInterface $clientRepository,
        protected ClientBuilderInterface $clientBuilder
    ) {
    }

    public function getClientByTelegram(ClientByTelegramRequest $request): Client
    {
        try {
            $client = $this->clientRepository->getClientByTelegramId($request->getTelegram());
        } catch (ClientNotFoundException) {
            $client = $this->clientBuilder
                ->setTelegramId($request->getTelegram())
                ->make();

            $this->clientRepository->createClient($client);
        }

        return $client;
    }
}
