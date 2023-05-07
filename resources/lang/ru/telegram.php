<?php

return [
    'network_error' => 'Технические неполадки, попробуйте позднее',
    'welcome_message' => 'Доброе пожаловать в Look Bot!',
    'support_message' => 'Опишите суть проблемы',
    'unknown_client' => 'Я вас не узнаю :(',
    'unknown_handler' => 'Я не знаю такой команды :(',
    'get_weather' => [
        'weather_message' => 'Ваш адрес: :address' . PHP_EOL . 'Прогноз погоды на :time_of_day от :min_temp до :max_temp',
        'default_error' => 'При получении погоды произошла ошибка',
        'afternoon' => ':current Погода на день',
        'evening' => ':current Погода на вечер',
        'night' => ':current Погода на ночь',
        'tomorrow' => ':current Погода на завтра',
        'date' => ':current Погода на :date',
        'accept' => 'Подтвердить',
        'need_location' => 'Для получения погоды мне нужно ваше местоположение',
        'send_location' => 'Отправить местоположение'
    ],
    'support' => [
        'send_message' => 'Опишите суть проблемы',
        'add_message' => 'Сообщение успешно доставлено, спасибо!'
    ],
    'menu' => [
        'message' => 'Меню',
        'points' => [
            'about' => 'О нас',
            'support' => 'Сообщить о проблеме',
            'get_weather' => 'Получить погоду'
        ]
    ]
];
