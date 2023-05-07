<?php

declare(strict_types=1);

namespace Look\Infrastructure\Repository\SupportMessage;

use Look\Domain\Exception\RepositoryException;
use Look\Domain\SupportMessage\Interface\SupportMessageInterface;
use Look\Domain\SupportMessage\Interface\SupportMessageRepositoryInterface;
use App\Models\SupportMessage;
use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Factory\ValueFactoryInterface;
use Psr\Log\LoggerInterface;

class EloquentSupportMessageRepository implements SupportMessageRepositoryInterface
{
    public function __construct(
        protected ValueFactoryInterface $valueFactory,
        protected LoggerInterface $logger
    ) {
    }

    public function createSupportMessage(SupportMessageInterface $supportMessage): void
    {
        $supportMessageModel = new SupportMessage();

        $this->fillModel($supportMessage, $supportMessageModel);

        if (!$supportMessageModel->save()) {
            $this->logger->emergency('Не удалось создать собщение для технической поддержки', [
                'support_message' => (array) $supportMessage
            ]);

            throw new RepositoryException('Failed to create support message');
        }

        try {
            $supportMessage->setId($this->valueFactory->makeId($supportMessageModel->id));
        } catch (InvalidValueException $exception) {
            $this->logger->emergency('Не удалось создать объект ID', [
                'id' => $supportMessageModel->id,
                'exception' => $exception
            ]);

            throw new RepositoryException('Fail to make ID');
        }
    }

    protected function fillModel(SupportMessageInterface $supportMessage, SupportMessage $supportMessageModel): void
    {
        $supportMessageModel->fill([
            'client_id' => $supportMessage->getClientId()->getValue(),
            'context' => $supportMessage->getContext(),
            'message' => $supportMessage->getMessage()->getValue()
        ]);
    }
}
