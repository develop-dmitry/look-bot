<?php

namespace App\Providers;

use App\Http\Controllers\TelegramController;
use Illuminate\Support\ServiceProvider;
use Look\Application\Client\ClientUseCaseInterface;
use Look\Application\Client\Request\ClientRequestFactory;
use Look\Application\Client\Request\Interface\ClientRequestFactoryInterface;
use Look\Application\Client\TelegramClientUseCase;
use Look\Domain\Entity\Client\Client;
use Look\Domain\Entity\Client\ClientBuilder;
use Look\Domain\Entity\Client\Interface\ClientBuilderInterface;
use Look\Domain\Entity\Client\Interface\ClientInterface;
use Look\Domain\Entity\Client\Interface\ClientRepositoryInterface;
use Look\Domain\Entity\Clothes\ClothesBuilder;
use Look\Domain\Entity\Clothes\Interface\ClothesBuilderInterface;
use Look\Domain\Entity\Clothes\Interface\ClothesRepositoryInterface;
use Look\Domain\Entity\Event\EventBuilder;
use Look\Domain\Entity\Event\Interface\EventBuilderInterface;
use Look\Domain\Entity\Event\Interface\EventRepositoryInterface;
use Look\Domain\Entity\Hair\HairBuilder;
use Look\Domain\Entity\Hair\Interface\HairBuilderInterface;
use Look\Domain\Entity\Hair\Interface\HairRepositoryInterface;
use Look\Domain\Entity\Look\Interface\LookBuilderInterface;
use Look\Domain\Entity\Look\Interface\LookRepositoryInterface;
use Look\Domain\Entity\Look\LookBuilder;
use Look\Domain\Entity\Makeup\Interface\MakeupBuilderInterface;
use Look\Domain\Entity\Makeup\Interface\MakeupRepositoryInterface;
use Look\Domain\Entity\Makeup\MakeupBuilder;
use Look\Domain\Entity\Season\Interface\SeasonBuilderInterface;
use Look\Domain\Entity\Season\Interface\SeasonRepositoryInterface;
use Look\Domain\Entity\Season\SeasonBuilder;
use Look\Domain\Entity\Style\Interface\StyleBuilderInterface;
use Look\Domain\Entity\Style\Interface\StyleRepositoryInterface;
use Look\Domain\Entity\Style\StyleBuilder;
use Look\Domain\Messenger\Button\ButtonFactory;
use Look\Domain\Messenger\Interface\ButtonFactoryInterface;
use Look\Domain\Messenger\Interface\KeyboardFactoryInterface;
use Look\Domain\Messenger\Interface\NextMessageHandlerRepositoryInterface;
use Look\Domain\Messenger\Interface\MessengerContainerFactoryInterface;
use Look\Domain\Messenger\Interface\MessengerInterface;
use Look\Domain\Messenger\Interface\MessengerRequestFactoryInterface;
use Look\Domain\Messenger\Interface\OptionFactoryInterface;
use Look\Domain\Messenger\Keyboard\KeyboardFactory;
use Look\Domain\Messenger\MessengerContainerFactory;
use Look\Domain\Messenger\Option\OptionFactory;
use Look\Domain\Messenger\Request\MessengerRequestFactory;
use Look\Domain\Repository\Filter\FilterOptionFactory;
use Look\Domain\Repository\Interface\Parameter\Filter\FilterOptionFactoryInterface;
use Look\Domain\Repository\Interface\Parameter\ParameterFactoryInterface;
use Look\Domain\Repository\Interface\Parameter\Sort\SortOptionFactoryInterface;
use Look\Domain\Repository\ParameterFactory;
use Look\Domain\Repository\Sort\SortOptionFactory;
use Look\Domain\Storage\Interface\Request\RequestFactoryInterface;
use Look\Domain\Storage\Interface\StorageInterface;
use Look\Domain\Value\Interface\ValueFactoryInterface;
use Look\Domain\Value\ValueFactory;
use Look\Infrastructure\Messenger\TelegramMessenger;
use Look\Infrastructure\Repository\ClientRepository;
use Look\Infrastructure\Repository\ClothesRepository;
use Look\Infrastructure\Repository\EventRepository;
use Look\Infrastructure\Repository\HairRepository;
use Look\Infrastructure\Repository\LookRepository;
use Look\Infrastructure\Repository\MakeupRepository;
use Look\Infrastructure\Repository\NextMessageHandlerRepository;
use Look\Infrastructure\Repository\SeasonRepository;
use Look\Infrastructure\Repository\StyleRepository;
use Look\Infrastructure\Storage\Database\ClientDatabaseStorage;
use Look\Infrastructure\Storage\Database\ClothesDatabaseStorage;
use Look\Infrastructure\Storage\Database\EventDatabaseStorage;
use Look\Infrastructure\Storage\Database\HairDatabaseStorage;
use Look\Infrastructure\Storage\Database\LookDatabaseStorage;
use Look\Infrastructure\Storage\Database\MakeupDatabaseStorage;
use Look\Infrastructure\Storage\Database\SeasonDatabaseStorage;
use Look\Infrastructure\Storage\Database\StyleDatabaseStorage;
use Look\Infrastructure\Storage\Redis\ClientRedisStorage;
use Look\Infrastructure\Storage\Request\RequestFactory;
use SergiX44\Nutgram\Nutgram;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ValueFactoryInterface::class, ValueFactory::class);

        $this->app->bind(ClientInterface::class, Client::class);
        $this->app->bind(ClientBuilderInterface::class, ClientBuilder::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(ClientRequestFactoryInterface::class, ClientRequestFactory::class);
        $this->app->when(ClientRepository::class)
            ->needs(StorageInterface::class)
            ->give(ClientDatabaseStorage::class);

        $this->app->bind(ClothesBuilderInterface::class, ClothesBuilder::class);
        $this->app->bind(ClothesRepositoryInterface::class, ClothesRepository::class);
        $this->app->when(ClothesRepository::class)
            ->needs(StorageInterface::class)
            ->give(ClothesDatabaseStorage::class);

        $this->app->bind(EventBuilderInterface::class, EventBuilder::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->when(EventRepository::class)
            ->needs(StorageInterface::class)
            ->give(EventDatabaseStorage::class);

        $this->app->bind(HairBuilderInterface::class, HairBuilder::class);
        $this->app->bind(HairRepositoryInterface::class, HairRepository::class);
        $this->app->when(HairRepository::class)
            ->needs(StorageInterface::class)
            ->give(HairDatabaseStorage::class);

        $this->app->bind(LookBuilderInterface::class, LookBuilder::class);
        $this->app->bind(LookRepositoryInterface::class, LookRepository::class);
        $this->app->when(LookRepository::class)
            ->needs(StorageInterface::class)
            ->give(LookDatabaseStorage::class);

        $this->app->bind(MakeupBuilderInterface::class, MakeupBuilder::class);
        $this->app->bind(MakeupRepositoryInterface::class, MakeupRepository::class);
        $this->app->when(MakeupRepository::class)
            ->needs(StorageInterface::class)
            ->give(MakeupDatabaseStorage::class);

        $this->app->bind(SeasonBuilderInterface::class, SeasonBuilder::class);
        $this->app->bind(SeasonRepositoryInterface::class, SeasonRepository::class);
        $this->app->when(SeasonRepository::class)
            ->needs(StorageInterface::class)
            ->give(SeasonDatabaseStorage::class);

        $this->app->bind(StyleBuilderInterface::class, StyleBuilder::class);
        $this->app->bind(StyleRepositoryInterface::class, StyleRepository::class);
        $this->app->when(StyleRepository::class)
            ->needs(StorageInterface::class)
            ->give(StyleDatabaseStorage::class);

        $this->app->bind(ButtonFactoryInterface::class, ButtonFactory::class);
        $this->app->bind(KeyboardFactoryInterface::class, KeyboardFactory::class);
        $this->app->bind(MessengerRequestFactoryInterface::class, MessengerRequestFactory::class);
        $this->app->bind(MessengerContainerFactoryInterface::class, MessengerContainerFactory::class);
        $this->app->bind(OptionFactoryInterface::class, OptionFactory::class);
        $this->app->bind(NextMessageHandlerRepositoryInterface::class, NextMessageHandlerRepository::class);
        $this->app->when(NextMessageHandlerRepository::class)
            ->needs(StorageInterface::class)
            ->give(ClientRedisStorage::class);

        $this->app->bind(FilterOptionFactoryInterface::class, FilterOptionFactory::class);
        $this->app->bind(SortOptionFactoryInterface::class, SortOptionFactory::class);
        $this->app->bind(ParameterFactoryInterface::class, ParameterFactory::class);
        $this->app->bind(RequestFactoryInterface::class, RequestFactory::class);

        $this->app->when(TelegramController::class)
            ->needs(MessengerInterface::class)
            ->give(TelegramMessenger::class);

        $this->app->when(TelegramMessenger::class)
            ->needs(Nutgram::class)
            ->give(static fn () => new Nutgram(config('telegram.look_token')));
        $this->app->when(TelegramMessenger::class)
            ->needs(ClientUseCaseInterface::class)
            ->give(TelegramClientUseCase::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
