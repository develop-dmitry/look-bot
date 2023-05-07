<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler;

use DateTime;
use Look\Application\Client\SaveClient\Interface\SaveClientInterface;
use Look\Application\Client\SaveClient\SaveClientRequest;
use Look\Application\Dictionary\DictionaryInterface;
use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonFactoryInterface;
use Look\Application\Messenger\MessengerContext\MessengerContextInterface;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerName;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerInterface;
use Look\Application\Messenger\MessengerHandler\Trait\Menu\HasMenu;
use Look\Application\Messenger\MessengerHandler\Trait\Menu\UseMenuInterface;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardFactoryInterface;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardInterface;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionFactoryInterface;
use Look\Application\Messenger\MessengerOption\MessengerButtonOption\MessengerButtonOptionName;
use Look\Application\Messenger\MessengerOption\MessengerKeyboardOption\MessengerKeyboardOptionName;
use Look\Application\Messenger\MessengerVisual\MessengerVisualInterface;
use Look\Application\Weather\GetWeather\GetWeatherRequest;
use Look\Application\Weather\GetWeather\Interface\GetWeatherInterface;
use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\TimeOfDay\TimeOfDay;
use Psr\Log\LoggerInterface;

class GetWeatherMessengerHandler implements MessengerHandlerInterface, UseMenuInterface
{
    use HasMenu;

    public function __construct(
        protected GetWeatherInterface               $getWeather,
        protected MessengerOptionFactoryInterface   $optionFactory,
        protected MessengerKeyboardFactoryInterface $keyboardFactory,
        protected MessengerButtonFactoryInterface   $buttonFactory,
        protected SaveClientInterface               $saveClient,
        protected LoggerInterface                   $logger,
        protected DictionaryInterface               $dictionary
    ) {
    }

    public function handle(MessengerContextInterface $context, MessengerVisualInterface $visual): void
    {
        if (!$context->isIdentifiedClient() || !$context->isIdentifiedMessengerUser()) {
            $visual->sendMessage($this->dictionary->getTranslate('telegram.unknown_client'));
        }

        $client = $context->getClient();
        $messengerUser = $context->getMessengerUser();
        $geoLocation = $context->getRequest()->getGeoLocation();

        if ($geoLocation) {
            $this->saveGeoLocation($geoLocation, $client);
        } else {
            $geoLocation = $client?->getGeoLocation();
        }

        if ($geoLocation) {
            $currentDate = new DateTime();
            $callbackQuery = $context->getRequest()->getCallbackQuery();
            $editMessage = false;

            if (isset($callbackQuery['time_of_day'])) {
                $timeOfDay = TimeOfDay::fromTimeOfDay($callbackQuery['time_of_day']);
                $editMessage = true;
            } else if (isset($callbackQuery['tomorrow'])) {
                $timeOfDay = TimeOfDay::fromDateTime(new DateTime('tomorrow noon'));
                $editMessage = true;
            } else {
                $timeOfDay = TimeOfDay::fromDateTime($currentDate);
            }

            $visual->sendMessage($this->getWeatherMessage($geoLocation, $timeOfDay), $editMessage);
            $visual->sendKeyboard($this->getWeatherKeyboard($currentDate, $timeOfDay));
        } else if ($messengerUser) {
            $messengerUser->setMessageHandler(MessengerHandlerName::GetWeatherText);

            $visual->sendMessage($this->dictionary->getTranslate('telegram.get_weather.need_location'));
            $visual->sendKeyboard($this->getGeoLocationKeyboard());
        }
    }

    protected function saveGeoLocation(GeoLocationInterface $geoLocation, ?ClientInterface $client): void
    {
        if (!$client) {
            return;
        }

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

            $timeOfDayText = match ($timeOfDay->getTimeOfDay()) {
                $timeOfDay::Afternoon => strtolower($this->dictionary->getTranslate('common.afternoon')),
                $timeOfDay::Evening => strtolower($this->dictionary->getTranslate('evening')),
                $timeOfDay::Night => strtolower($this->dictionary->getTranslate('night')),
                default => ''
            };

            return $this->dictionary->getTranslate('telegram.get_weather.weather_message', [
                'address' => $weather?->getGeoLocation()->getAddress()?->getValue(),
                'date' => $timeOfDay->getDate()->format('d F'),
                'time_of_day' => $timeOfDayText,
                'min_temp' => $weather?->getMinTemperature()->getFormatValue(),
                'max_temp' => $weather?->getMaxTemperature()->getFormatValue()
            ]);
        }

        return ($response->getError()) ?: $this->dictionary->getTranslate('telegram.get_weather.default_error');
    }

    protected function getWeatherKeyboard(DateTime $date, TimeOfDay $currentTimeOfDay): MessengerKeyboardInterface
    {
        $isTomorrow = $date->format('Y-m-d') !== $currentTimeOfDay->getDate()->format('Y-m-d');
        $keyboard = $this->keyboardFactory->makeInlineKeyboard();

        $acceptCallbackOption = $this->optionFactory->makeCallbackDataButtonOption()
            ->setName(MessengerButtonOptionName::CallbackData->value)
            ->setValue(['action' => 'accept']);

        $acceptButton = $this->buttonFactory->makeInlineButton()
            ->setText($this->dictionary->getTranslate('telegram.get_weather.accept'))
            ->addOption($acceptCallbackOption);

        $keyboard->addRow($acceptButton);

        foreach (TimeOfDay::getValuesList() as $nextTime) {
            $isCurrentTime = $nextTime === $currentTimeOfDay->getTimeOfDay() && !$isTomorrow;

            $timeButtonText = match ($nextTime) {
                TimeOfDay::Afternoon => $this->dictionary->getTranslate('telegram.get_weather.afternoon', [
                    'current' => ($isCurrentTime) ? '👉 ' : ''
                ]),
                TimeOfDay::Evening => $this->dictionary->getTranslate('telegram.get_weather.evening', [
                    'current' => ($isCurrentTime) ? '👉 ' : ''
                ]),
                TimeOfDay::Night => $this->dictionary->getTranslate('telegram.get_weather.night', [
                    'current' => ($isCurrentTime) ? '👉 ' : ''
                ]),
                default => ''
            };

            if (!$timeButtonText) {
                continue;
            }

            $timeCallbackOption = $this->optionFactory->makeCallbackDataButtonOption()
                ->setName(MessengerButtonOptionName::CallbackData->value)
                ->setValue([
                    'action' => MessengerHandlerName::GetWeatherCallbackQuery->value,
                    'time_of_day' => $nextTime
                ]);

            $timeButton = $this->buttonFactory->makeInlineButton()
                ->setText($timeButtonText)
                ->addOption($timeCallbackOption);

            $keyboard->addRow($timeButton);
        }

        $tomorrowCallbackOption = $this->optionFactory->makeCallbackDataButtonOption()
            ->setName(MessengerButtonOptionName::CallbackData->value)
            ->setValue(['action' => MessengerHandlerName::GetWeatherCallbackQuery->value, 'tomorrow' => true]);


        $tomorrowButton = $this->buttonFactory->makeInlineButton()
            ->setText($this->dictionary->getTranslate('telegram.get_weather.tomorrow', [
                'current' => ($isTomorrow && $currentTimeOfDay->getTimeOfDay() !== TimeOfDay::Night) ? '👉 ' : ''
            ]))
            ->addOption($tomorrowCallbackOption);

        $keyboard->addRow($tomorrowButton);

        return $keyboard;
    }

    protected function getGeoLocationKeyboard(): MessengerKeyboardInterface
    {
        $keyboardOptions[] = $this->optionFactory->makeKeyboardOption()
            ->setName(MessengerKeyboardOptionName::ResizeKeyboard->value)
            ->setValue(true);

        $requestLocationOption = $this->optionFactory->makeButtonOption()
            ->setName(MessengerButtonOptionName::RequestLocation->value)
            ->setValue(true);

        $requestLocationButton = $this->buttonFactory->makeReplyButton()
            ->setText($this->dictionary->getTranslate('telegram.get_weather.send_location'))
            ->addOption($requestLocationOption);

        $keyboard = $this->keyboardFactory->makeReplyKeyboard();
        $keyboard->addOption(...$keyboardOptions);
        $keyboard->addRow($requestLocationButton);

        return $keyboard;
    }
}
