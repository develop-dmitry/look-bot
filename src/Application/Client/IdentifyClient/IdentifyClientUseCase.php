<?php

declare(strict_types=1);

namespace Look\Application\Client\IdentifyClient;

use Look\Application\Client\IdentifyClient\Interface\IdentifyClientInterface;
use Look\Application\Client\IdentifyClient\Interface\IdentifyClientRequestInterface;
use Look\Application\Client\IdentifyClient\Interface\IdentifyClientResponseInterface;
use Look\Domain\Client\Exception\ClientNotFoundException;
use Look\Domain\Client\Interface\ClientBuilderInterface;
use Look\Domain\Client\Interface\ClientRepositoryInterface;
use Look\Domain\Exception\RepositoryException;
use Look\Domain\Value\Exception\InvalidValueException;
use Psr\Log\LoggerInterface;

class IdentifyClientUseCase implements IdentifyClientInterface
{
    public function __construct(
        protected ClientRepositoryInterface $clientRepository,
        protected ClientBuilderInterface $clientBuilder,
        protected LoggerInterface $logger
    ) {
    }

    public function identifyClientFromTelegram(IdentifyClientRequestInterface $request): IdentifyClientResponseInterface
    {
        try {
            $client = $this->clientRepository->getClientByTelegramId($request->getUid());
        } catch (ClientNotFoundException $exception) {
            $client = $this->clientBuilder
                ->setTelegramId($request->getUid())
                ->make();

            $this->clientRepository->createClient($client);
        } catch (RepositoryException|InvalidValueException $exception) {
            $this->logger->emergency('Не удалось идентифицировать пользователя', [
                'request' => $request,
                'exception' => $exception
            ]);

            return new IdentifyClientResponse(false, 'Технические неполадки, попробуйте позднее');
        }

        return new IdentifyClientResponse(true, '', $client);
    }
}
