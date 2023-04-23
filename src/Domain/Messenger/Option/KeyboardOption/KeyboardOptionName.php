<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Option\KeyboardOption;

enum KeyboardOptionName: string
{
    case ResizeKeyboard = 'resize_keyboard';

    case OneTimeKeyboard = 'one_time_keyboard';

    case InputFieldPlaceholder = 'input_field_placeholder';

    case Selective = 'selective';

    case IsPersistent = 'is_persistent';

    case Null = 'null';
}
