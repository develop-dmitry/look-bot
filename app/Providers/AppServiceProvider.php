<?php

namespace App\Providers;

use App\Http\Controllers\TelegramController;
use Illuminate\Support\ServiceProvider;
use Look\Application\Client\IdentifyClient\IdentifyClientUseCase;
use Look\Application\Client\IdentifyClient\Interface\IdentifyClientInterface;
use Look\Application\Client\SaveClient\Interface\SaveClientInterface;
use Look\Application\Client\SaveClient\SaveClientUseCase;
use Look\Application\Clothes\ChooseClothes\ChooseClothesUseCase;
use Look\Application\Clothes\ChooseClothes\Interface\ChooseClothesInterface;
use Look\Application\Clothes\GetClothesForClient\GetClothesForClientUseCase;
use Look\Application\Clothes\GetClothesForClient\Interface\GetClothesForClientInterface;
use Look\Application\Dictionary\Dictionary;
use Look\Application\Dictionary\DictionaryInterface;
use Look\Application\FormatDate\FormatDate;
use Look\Application\FormatDate\FormatDateInterface;
use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonFactoryInterface;
use Look\Application\Messenger\MessengerButton\MessengerButtonFactory;
use Look\Application\Messenger\MessengerContainer\Interface\MessengerContainerFactoryInterface;
use Look\Application\Messenger\MessengerContainer\MessengerContainerFactory;
use Look\Application\Messenger\MessengerHandler\GetWeatherMessengerHandler;
use Look\Application\Messenger\MessengerInterface;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardFactoryInterface;
use Look\Application\Messenger\MessengerKeyboard\MessengerKeyboardFactory;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionFactoryInterface;
use Look\Application\Messenger\MessengerOption\MessengerOptionFactory;
use Look\Application\Messenger\MessengerUser\FindMessengerUser\FindMessengerUserUseCase;
use Look\Application\Messenger\MessengerUser\FindMessengerUser\Interface\FindMessengerUserInterface;
use Look\Application\Messenger\MessengerUser\SaveMessengerUser\Interface\SaveMessengerUserInterface;
use Look\Application\Messenger\MessengerUser\SaveMessengerUser\SaveMessengerUserUseCase;
use Look\Application\SupportMessage\CreateSupportMessage\CreateSupportMessageUseCase;
use Look\Application\SupportMessage\CreateSupportMessage\Interface\CreateSupportMessageInterface;
use Look\Application\Weather\GetWeather\GetWeatherUseCase;
use Look\Application\Weather\GetWeather\Interface\GetWeatherInterface;
use Look\Domain\Client\Client;
use Look\Domain\Client\ClientBuilder;
use Look\Domain\Client\Interface\ClientBuilderInterface;
use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\Client\Interface\ClientRepositoryInterface;
use Look\Domain\Clothes\ClothesBuilder;
use Look\Domain\Clothes\Interface\ClothesBuilderInterface;
use Look\Domain\Clothes\Interface\ClothesRepositoryInterface;
use Look\Domain\GeoLocation\GeoLocationBuilder;
use Look\Domain\GeoLocation\Interface\GeoLocationBuilderInterface;
use Look\Domain\MessengerUser\Interface\MessengerUserBuilderInterface;
use Look\Domain\MessengerUser\MessengerUserBuilder;
use Look\Domain\SupportMessage\Interface\SupportMessageBuilderInterface;
use Look\Domain\SupportMessage\Interface\SupportMessageRepositoryInterface;
use Look\Domain\SupportMessage\SupportMessageBuilder;
use Look\Domain\Value\Factory\ValueFactory;
use Look\Domain\Value\Factory\ValueFactoryInterface;
use Look\Domain\Weather\Interface\WeatherBuilderInterface;
use Look\Domain\Weather\Interface\WeatherCacheInterface;
use Look\Domain\Weather\Interface\WeatherGatewayInterface;
use Look\Domain\Weather\WeatherBuilder;
use Look\Infrastructure\Cache\Weather\WeatherCache;
use Look\Infrastructure\Gateway\Weather\WeatherGateway;
use Look\Infrastructure\Messenger\TelegramMessenger\TelegramMessenger;
use Look\Infrastructure\Repository\ClientRepository\EloquentClientRepository;
use Look\Infrastructure\Repository\ClothesRepository\EloquentClothesRepository;
use Look\Infrastructure\Repository\MessengerUserRepository\TelegramMessengerUserRepository;
use Look\Infrastructure\Repository\SupportMessage\EloquentSupportMessageRepository;
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
        $this->app->bind(SaveClientInterface::class, SaveClientUseCase::class);

        $this->app->bind(GeoLocationBuilderInterface::class, GeoLocationBuilder::class);

        $this->app->bind(WeatherBuilderInterface::class, WeatherBuilder::class);
        $this->app->bind(GetWeatherInterface::class, GetWeatherUseCase::class);
        $this->app->bind(WeatherGatewayInterface::class, WeatherGateway::class);
        $this->app->bind(WeatherCacheInterface::class, WeatherCache::class);
        $this->app->when(WeatherGateway::class)
            ->needs('$token')
            ->give(config('services.weather.token'));

        $this->app->bind(SupportMessageBuilderInterface::class, SupportMessageBuilder::class);
        $this->app->bind(SupportMessageRepositoryInterface::class, EloquentSupportMessageRepository::class);
        $this->app->bind(CreateSupportMessageInterface::class, CreateSupportMessageUseCase::class);

        $this->app->bind(ClothesBuilderInterface::class, ClothesBuilder::class);
        $this->app->bind(ClothesRepositoryInterface::class, EloquentClothesRepository::class);
        $this->app->bind(GetClothesForClientInterface::class, GetClothesForClientUseCase::class);
        $this->app->bind(ChooseClothesInterface::class, ChooseClothesUseCase::class);

        $this->app->bind(MessengerButtonFactoryInterface::class, MessengerButtonFactory::class);
        $this->app->bind(MessengerKeyboardFactoryInterface::class, MessengerKeyboardFactory::class);
        $this->app->bind(MessengerContainerFactoryInterface::class, MessengerContainerFactory::class);
        $this->app->bind(MessengerOptionFactoryInterface::class, MessengerOptionFactory::class);
        $this->app->bind(MessengerUserBuilderInterface::class, MessengerUserBuilder::class);
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

        $this->app->bind(DictionaryInterface::class, Dictionary::class);
        $this->app->when(Dictionary::class)
            ->needs('$locale')
            ->give(config('app.locale'));

        $this->app->bind(FormatDateInterface::class, FormatDate::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
