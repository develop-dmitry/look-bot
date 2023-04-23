<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Option\ButtonOption;

enum ButtonOptionName: string
{
    case Url = 'url';

    case LoginUrl = 'login_url';

    case CallbackData = 'callback_data';

    case SwitchInlineQuery = 'switch_inline_query';

    case SwitchInlineQueryCurrentChat = 'switch_inline_query_current_chat';

    case CallbackGame = 'callback_game';

    case Pay = 'pay';

    case WebApp = 'web_app';

    case RequestContact = 'request_contact';

    case RequestLocation = 'request_location';

    case RequestPoll = 'request_poll';

    case RequestUser = 'request_user';

    case RequestChat = 'request_chat';

    case Null = 'null';
}
