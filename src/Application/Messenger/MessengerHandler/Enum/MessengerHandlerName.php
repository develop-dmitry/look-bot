<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler\Enum;

enum MessengerHandlerName: string
{
    case Start = 'start';

    case Menu = 'menu';

    case Support = 'Сообщить о проблеме';

    case AddSupportMessage = 'add_support_message';

    case GetWeatherText = 'Получить погоду';

    case GetWeatherCallbackQuery = 'get_weather';
}
