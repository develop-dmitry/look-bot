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
use Look\Domain\Entity\Event\EventBuilder;
use Look\Domain\Entity\Event\Interface\EventBuilderInterface;
use Look\Domain\Entity\Hair\HairBuilder;
use Look\Domain\Entity\Hair\Interface\HairBuilderInterface;
use Look\Domain\Entity\Look\Interface\LookBuilderInterface;
use Look\Domain\Entity\Look\LookBuilder;
use Look\Domain\Entity\Makeup\Interface\MakeupBuilderInterface;
use Look\Domain\Entity\Makeup\MakeupBuilder;
use Look\Domain\Entity\MessengerUser\Interface\MessengerUserBuilderInterface;
use Look\Domain\Entity\MessengerUser\Interface\MessengerUserRepositoryInterface;
use Look\Domain\Entity\MessengerUser\Interface\TelegramMessengerUserRepositoryInterface;
use Look\Domain\Entity\MessengerUser\MessengerUserBuilder;
use Look\Domain\Entity\Season\Interface\SeasonBuilderInterface;
use Look\Domain\Entity\Season\SeasonBuilder;
use Look\Domain\Entity\Style\Interface\StyleBuilderInterface;
use Look\Domain\Entity\Style\StyleBuilder;
use Look\Domain\Messenger\Button\ButtonFactory;
use Look\Domain\Messenger\Interface\ButtonFactoryInterface;
use Look\Domain\Messenger\Interface\KeyboardFactoryInterface;
use Look\Domain\Messenger\Interface\MessengerContainerFactoryInterface;
use Look\Domain\Messenger\Interface\MessengerInterface;
use Look\Domain\Messenger\Interface\MessengerRequestFactoryInterface;
use Look\Domain\Messenger\Interface\OptionFactoryInterface;
use Look\Domain\Messenger\Keyboard\KeyboardFactory;
use Look\Domain\Messenger\MessengerContainerFactory;
use Look\Domain\Messenger\Option\OptionFactory;
use Look\Domain\Messenger\Request\MessengerRequestFactory;
use Look\Domain\Value\Interface\ValueFactoryInterface;
use Look\Domain\Value\ValueFactory;
use Look\Infrastructure\Messenger\TelegramMessenger;
use Look\Infrastructure\Repository\EloquentClientRepository;
use Look\Infrastructure\Repository\MessengerUserRepository\AbstractRedisMessengerUserRepository;
use Look\Infrastructure\Repository\MessengerUserRepository\RedisTelegramMessengerUserRepository;
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
        $this->app->bind(ClientRepositoryInterface::class, EloquentClientRepository::class);
        $this->app->bind(ClientRequestFactoryInterface::class, ClientRequestFactory::class);

        $this->app->bind(MessengerUserBuilderInterface::class, MessengerUserBuilder::class);
        $this->app->bind(
            TelegramMessengerUserRepositoryInterface::class,
            RedisTelegramMessengerUserRepository::class
        );

        $this->app->bind(ClothesBuilderInterface::class, ClothesBuilder::class);

        $this->app->bind(EventBuilderInterface::class, EventBuilder::class);

        $this->app->bind(HairBuilderInterface::class, HairBuilder::class);

        $this->app->bind(LookBuilderInterface::class, LookBuilder::class);

        $this->app->bind(MakeupBuilderInterface::class, MakeupBuilder::class);

        $this->app->bind(SeasonBuilderInterface::class, SeasonBuilder::class);

        $this->app->bind(StyleBuilderInterface::class, StyleBuilder::class);

        $this->app->bind(ButtonFactoryInterface::class, ButtonFactory::class);
        $this->app->bind(KeyboardFactoryInterface::class, KeyboardFactory::class);
        $this->app->bind(MessengerRequestFactoryInterface::class, MessengerRequestFactory::class);
        $this->app->bind(MessengerContainerFactoryInterface::class, MessengerContainerFactory::class);
        $this->app->bind(OptionFactoryInterface::class, OptionFactory::class);

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
