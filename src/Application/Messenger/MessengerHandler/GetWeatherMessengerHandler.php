<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler;

use DateTime;
use Look\Application\Client\SaveClient\Interface\SaveClientInterface;
use Look\Application\Client\SaveClient\SaveClientRequest;
use Look\Application\Dictionary\DictionaryInterface;
use Look\Application\FormatDate\FormatDateInterface;
use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonFactoryInterface;
use Look\Application\Messenger\MessengerContext\MessengerContextInterface;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerName;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerType;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerInterface;
use Look\Application\Messenger\MessengerHandler\Trait\UseMainMenu\HasMainMenu;
use Look\Application\Messenger\MessengerHandler\Trait\UseMainMenu\UseMainMenuInterface;
use Look\Application\Messenger\MessengerKeyboard\Exception\FailedAddRowKeyboardException;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardFactoryInterface;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardInterface;
use Look\Application\Messenger\MessengerOption\Exception\FailedAddOptionException;
use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionNameException;
use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionValueException;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionFactoryInterface;
use Look\Application\Messenger\MessengerOption\MessengerKeyboardOption\MessengerKeyboardOptionName;
use Look\Application\Messenger\MessengerVisual\MessengerVisualInterface;
use Look\Application\Weather\GetWeather\GetWeatherRequest;
use Look\Application\Weather\GetWeather\Interface\GetWeatherInterface;
use Look\Application\Weather\GetWeatherMenu\Interface\GetWeatherMenuInterface;
use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\TimeOfDay\TimeOfDay;
use Psr\Log\LoggerInterface;

class GetWeatherMessengerHandler implements MessengerHandlerInterface, UseMainMenuInterface
{
    use HasMainMenu;

    protected string $dateFormat = 'Y-m-d H:i:s';

    protected MessengerContextInterface $context;

    protected MessengerVisualInterface $visual;

    public function __construct(
        protected GetWeatherInterface               $getWeather,
        protected MessengerOptionFactoryInterface   $optionFactory,
        protected MessengerKeyboardFactoryInterface $keyboardFactory,
        protected MessengerButtonFactoryInterface   $buttonFactory,
        protected SaveClientInterface               $saveClient,
        protected LoggerInterface                   $logger,
        protected DictionaryInterface               $dictionary,
        protected FormatDateInterface               $formatDate,
        protected GetWeatherMenuInterface           $weatherMenu
    ) {
    }

    public function handle(MessengerContextInterface $context, MessengerVisualInterface $visual): void
    {
        if (!$context->isIdentifiedClient() || !$context->isIdentifiedMessengerUser()) {
            $visual->sendMessage($this->dictionary->getTranslate('telegram.unknown_client'));
        }

        $this->context = $context;
        $this->visual = $visual;

        $client = $context->getClient();
        $geoLocation = $context->getRequest()->getGeoLocation();

        if ($geoLocation) {
            $this->saveGeoLocation($geoLocation, $client);
        } else {
            $geoLocation = $client?->getGeoLocation();
        }

        if ($geoLocation) {
            $this->printWeather($geoLocation);
        } else {
            $this->needGeoLocation();
        }
    }

    public function getTypes(): array
    {
        return [MessengerHandlerType::Text, MessengerHandlerType::Message, MessengerHandlerType::CallbackQuery];
    }

    public function getNames(): array
    {
        return [MessengerHandlerName::GetWeatherText, MessengerHandlerName::GetWeatherCallbackQuery];
    }

    protected function printWeather(GeoLocationInterface $geoLocation): void
    {
        $callbackQuery = $this->context->getRequest()->getCallbackQuery();
        $date = new DateTime();
        $editMessage = false;

        if (isset($callbackQuery['date'])) {
            $date = DateTime::createFromFormat($this->dateFormat, $callbackQuery['date']);
            $editMessage = true;
        }

        $timeOfDay = TimeOfDay::fromDateTime($date);

        $this->visual->sendMessage($this->getWeatherMessage($geoLocation, $timeOfDay), $editMessage);
        $this->visual->sendKeyboard($this->getWeatherKeyboard($timeOfDay));
    }

    protected function needGeoLocation(): void
    {
        $messengerUser = $this->context->getMessengerUser();
        $messengerUser->setMessageHandler(MessengerHandlerName::GetWeatherText);

        $this->visual->sendMessage($this->dictionary->getTranslate('telegram.get_weather.need_location'));
        $this->visual->sendKeyboard($this->getGeoLocationKeyboard());
    }

    protected function saveGeoLocation(GeoLocationInterface $geoLocation, ClientInterface $client): void
    {
        $client->setGeoLocation($geoLocation);
        $request = new SaveClientRequest($client);

        $this->saveClient->saveClient($request);
    }

    protected function getWeatherMessage(
        GeoLocationInterface $geoLocation,
        TimeOfDay $timeOfDay
    ): string {
        $request = new GetWeatherRequest($geoLocation, $timeOfDay);
        $response = $this->getWeather->getWeather($request);

        if ($response->isSuccess()) {
            $weather = $response->getWeather();

            if (
                $timeOfDay->isToday() ||
                ($timeOfDay->isTomorrow() && $timeOfDay->getTimeOfDay() === TimeOfDay::Night)
            ) {
                $timeOfDayText = mb_strtolower(match ($timeOfDay->getTimeOfDay()) {
                    $timeOfDay::Afternoon => strtolower($this->dictionary->getTranslate('common.afternoon')),
                    $timeOfDay::Evening => strtolower($this->dictionary->getTranslate('common.evening')),
                    $timeOfDay::Night => strtolower($this->dictionary->getTranslate('common.night')),
                    default => ''
                });
            } else {
                $timeOfDayText = strtolower($this->dictionary->getTranslate('common.tomorrow'));
            }

            return $this->dictionary->getTranslate('telegram.get_weather.weather_message', [
                'address' => $weather?->getGeoLocation()->getAddress()?->getValue(),
                'time_of_day' => $timeOfDayText,
                'min_temp' => $weather?->getMinTemperature()->getFormatValue(),
                'max_temp' => $weather?->getMaxTemperature()->getFormatValue()
            ]);
        }

        return ($response->getError()) ?: $this->dictionary->getTranslate('telegram.get_weather.default_error');
    }

    protected function getWeatherKeyboard(TimeOfDay $currentTimeOfDay): ?MessengerKeyboardInterface
    {
        try {
            $keyboard = $this->keyboardFactory->makeInlineKeyboard();

            $keyboard->addRow(
                $this->buttonFactory->makeCallbackDataInlineButton(['action' => 'accept'])
                    ->setText($this->dictionary->getTranslate('telegram.get_weather.accept'))
            );

            foreach ($this->weatherMenu->getWeatherMenu()->getMenu() as $point) {
                if ($point->isToday() || ($point->isTomorrow() && $point->getTimeOfDay() === TimeOfDay::Night)) {
                    $dictionaryKey = match ($point->getTimeOfDay()) {
                        TimeOfDay::Afternoon => 'telegram.get_weather.afternoon',
                        TimeOfDay::Evening => 'telegram.get_weather.evening',
                        TimeOfDay::Night => 'telegram.get_weather.night',
                        default => 'telegram.get_weather.date'
                    };
                } else if ($point->isTomorrow()) {
                    $dictionaryKey = 'telegram.get_weather.tomorrow';
                } else {
                    $dictionaryKey = 'telegram.get_weather.date';
                }

                $callbackData = [
                    'action' => MessengerHandlerName::GetWeatherCallbackQuery->value,
                    'date' => $point->getDate()->format($this->dateFormat)
                ];
                $text = $this->dictionary->getTranslate($dictionaryKey, [
                    'current' => ($currentTimeOfDay->equal($point)) ? '👉' : '',
                    'date' => $this->formatDate->short($point->getDate())
                ]);

                $keyboard->addRow(
                    $this->buttonFactory->makeCallbackDataInlineButton($callbackData)
                        ->setText($text)
                );
            }

            return $keyboard;
        } catch (
            FailedAddRowKeyboardException|
            FailedAddOptionException|
            FailedSetOptionNameException|
            FailedSetOptionValueException $exception
        ) {
            $this->logger->emergency('Не удалось создать клавиатуру для погоды', ['exception' => $exception]);

            return null;
        }
    }

    protected function getGeoLocationKeyboard(): ?MessengerKeyboardInterface
    {
        try {
            return $this->keyboardFactory->makeReplyKeyboard()
                ->addOption(
                    $this->optionFactory->makeKeyboardOption()
                        ->setName(MessengerKeyboardOptionName::ResizeKeyboard->value)
                        ->setValue(true)
                )
                ->addRow(
                    $this->buttonFactory->makeLocationReplyButton()
                        ->setText($this->dictionary->getTranslate('telegram.get_weather.send_location'))
                );
        } catch (
            FailedAddRowKeyboardException|
            FailedAddOptionException|
            FailedSetOptionNameException|
            FailedSetOptionValueException $exception
        ) {
            $this->logger->emergency('Не удалось создать клавиатуру для геолокации', ['exception' => $exception]);

            return null;
        }
    }
}
