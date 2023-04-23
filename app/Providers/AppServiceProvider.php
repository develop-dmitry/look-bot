<?php

namespace App\Providers;

use App\Http\Controllers\TelegramController;
use Illuminate\Support\ServiceProvider;
use Look\Domain\Client\Entity\Client;
use Look\Domain\Client\Entity\ClientBuilder;
use Look\Domain\Client\Interface\ClientBuilderInterface;
use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\Client\Interface\ClientRepositoryInterface;
use Look\Domain\Messenger\Button\ButtonFactory;
use Look\Domain\Messenger\Interface\ButtonFactoryInterface;
use Look\Domain\Messenger\Interface\KeyboardFactoryInterface;
use Look\Domain\Messenger\Interface\MessageHandlerRepositoryInterface;
use Look\Domain\Messenger\Interface\MessengerContainerFactoryInterface;
use Look\Domain\Messenger\Interface\MessengerInterface;
use Look\Domain\Messenger\Interface\MessengerRequestFactoryInterface;
use Look\Domain\Messenger\Interface\OptionFactoryInterface;
use Look\Domain\Messenger\Keyboard\KeyboardFactory;
use Look\Domain\Messenger\MessengerContainerFactory;
use Look\Domain\Messenger\Option\OptionFactory;
use Look\Domain\Messenger\Request\MessengerRequestFactory;
use Look\Infrastructure\Messenger\TelegramMessenger;
use Look\Infrastructure\Repository\ClientRepository;
use Look\Infrastructure\Repository\MessengerHandlerRepository;
use SergiX44\Nutgram\Nutgram;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ClientInterface::class, Client::class);
        $this->app->bind(ClientBuilderInterface::class, ClientBuilder::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);

        $this->app->bind(ButtonFactoryInterface::class, ButtonFactory::class);
        $this->app->bind(KeyboardFactoryInterface::class, KeyboardFactory::class);
        $this->app->bind(MessengerRequestFactoryInterface::class, MessengerRequestFactory::class);
        $this->app->bind(MessengerContainerFactoryInterface::class, MessengerContainerFactory::class);
        $this->app->bind(OptionFactoryInterface::class, OptionFactory::class);
        $this->app->bind(MessageHandlerRepositoryInterface::class, MessengerHandlerRepository::class);

        $this->app->when(TelegramController::class)
            ->needs(MessengerInterface::class)
            ->give(TelegramMessenger::class);

        $this->app->when(TelegramMessenger::class)
            ->needs(Nutgram::class)
            ->give(static fn () => new Nutgram(config('telegram.look_token')));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
