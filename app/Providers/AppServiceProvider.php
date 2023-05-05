<?php

namespace App\Providers;

use App\Http\Controllers\TelegramController;
use Illuminate\Support\ServiceProvider;
use Look\Application\Client\IdentifyClient\IdentifyClientUseCase;
use Look\Application\Client\IdentifyClient\Interface\IdentifyClientInterface;
use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonFactoryInterface;
use Look\Application\Messenger\MessengerButton\MessengerButtonFactory;
use Look\Application\Messenger\MessengerContainer\Interface\MessengerContainerFactoryInterface;
use Look\Application\Messenger\MessengerContainer\MessengerContainerFactory;
use Look\Application\Messenger\MessengerInterface;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardFactoryInterface;
use Look\Application\Messenger\MessengerKeyboard\MessengerKeyboardFactory;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionFactoryInterface;
use Look\Application\Messenger\MessengerOption\MessengerOptionFactory;
use Look\Application\Messenger\MessengerRequest\Interface\MessengerRequestFactoryInterface;
use Look\Application\Messenger\MessengerRequest\MessengerRequestFactory;
use Look\Application\Messenger\MessengerUser\FindMessengerUser\FindMessengerUserUseCase;
use Look\Application\Messenger\MessengerUser\FindMessengerUser\Interface\FindMessengerUserInterface;
use Look\Application\Messenger\MessengerUser\SaveMessengerUser\Interface\SaveMessengerUserInterface;
use Look\Application\Messenger\MessengerUser\SaveMessengerUser\SaveMessengerUserUseCase;
use Look\Domain\Client\Client;
use Look\Domain\Client\ClientBuilder;
use Look\Domain\Client\Interface\ClientBuilderInterface;
use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\Client\Interface\ClientRepositoryInterface;
use Look\Domain\MessengerUser\Interface\MessengerUserBuilderInterface;
use Look\Domain\MessengerUser\MessengerUserBuilder;
use Look\Domain\Value\Factory\ValueFactory;
use Look\Domain\Value\Factory\ValueFactoryInterface;
use Look\Infrastructure\Messenger\TelegramMessenger\TelegramMessenger;
use Look\Infrastructure\Repository\ClientRepository\EloquentClientRepository;
use Look\Infrastructure\Repository\MessengerUserRepository\TelegramMessengerUserRepository;
use Psr\Log\LoggerInterface;
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
        $this->app->bind(IdentifyClientInterface::class, IdentifyClientUseCase::class);

        $this->app->bind(MessengerUserBuilderInterface::class, MessengerUserBuilder::class);

        $this->app->bind(MessengerButtonFactoryInterface::class, MessengerButtonFactory::class);
        $this->app->bind(MessengerKeyboardFactoryInterface::class, MessengerKeyboardFactory::class);
        $this->app->bind(MessengerRequestFactoryInterface::class, MessengerRequestFactory::class);
        $this->app->bind(MessengerContainerFactoryInterface::class, MessengerContainerFactory::class);
        $this->app->bind(MessengerOptionFactoryInterface::class, MessengerOptionFactory::class);
        $this->app->bind('telegramMessengerUserRepository', TelegramMessengerUserRepository::class);

        $this->app->when(TelegramController::class)
            ->needs(MessengerInterface::class)
            ->give(TelegramMessenger::class);

        $this->app->when(TelegramMessenger::class)
            ->needs(Nutgram::class)
            ->give(static fn () => new Nutgram(config('telegram.look_token')));
        $this->app->when(TelegramMessenger::class)
            ->needs(FindMessengerUserInterface::class)
            ->give(function () {
                return new FindMessengerUserUseCase(
                    $this->app->make('telegramMessengerUserRepository'),
                    $this->app->get(LoggerInterface::class)
                );
            });
        $this->app->when(TelegramMessenger::class)
            ->needs(SaveMessengerUserInterface::class)
            ->give(function () {
                return new SaveMessengerUserUseCase(
                    $this->app->make('telegramMessengerUserRepository'),
                    $this->app->get(LoggerInterface::class)
                );
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
