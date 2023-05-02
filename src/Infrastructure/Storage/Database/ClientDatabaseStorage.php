<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Database;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Look\Domain\Entity\Client\Interface\ClientBuilderInterface;
use Look\Domain\Entity\Client\Interface\ClientInterface;
use Psr\Log\LoggerInterface;

class ClientDatabaseStorage extends AbstractDatabaseStorage
{
    protected string $model = Client::class;

    public function __construct(
        protected ClientBuilderInterface $clientBuilder,
        LoggerInterface $logger
    ) {
        parent::__construct($logger);
    }

    protected function makeEntity(Model $model): ClientInterface
    {
        return $this->clientBuilder
            ->setId($model->id)
            ->setUserId($model->user_id)
            ->setTelegramId($model->telegram_id)
            ->make();
    }
}
