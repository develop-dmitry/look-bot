<?php

declare(strict_types=1);

namespace Look\Infrastructure\Messenger\TelegramMessenger;

use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonInterfaceMessenger;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardInterface;
use Look\Application\Messenger\MessengerKeyboard\MessengerKeyboardType;
use Look\Application\Messenger\MessengerOption\MessengerButtonOption\MessengerButtonOptionName;
use Look\Application\Messenger\MessengerOption\MessengerKeyboardOption\MessengerKeyboardOptionName;
use Look\Application\Messenger\MessengerVisual\MessengerVisualInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

class TelegramMessengerVisual implements MessengerVisualInterface
{
    protected ?MessengerKeyboardInterface $keyboard = null;

    protected string $message = '';

    protected bool $editMessage = false;

    public function __construct(
        protected Nutgram $bot
    ) {
    }

    public function sendMessage(string $message, bool $editMessage = false): void
    {
        $this->message = $message;
        $this->editMessage = $editMessage;
    }

    public function sendKeyboard(MessengerKeyboardInterface $keyboard): void
    {
        $this->keyboard = $keyboard;
    }

    public function makeMessage(): bool|array|Message|null
    {
        $options = $this->getMessageOptions();

        if ($this->editMessage) {
            return $this->bot->editMessageText($this->message, $options);
        }

        return $this->bot->sendMessage($this->message, $options);
    }

    protected function getMessageOptions(): array
    {
        $options = [];

        if ($this->keyboard) {
            $options['reply_markup'] = $this->adaptKeyboard();
        }

        return $options;
    }

    protected function adaptKeyboard(): ReplyKeyboardMarkup|InlineKeyboardMarkup|null
    {
        return match ($this->keyboard->getType()) {
            MessengerKeyboardType::Inline => $this->makeInlineKeyboardMarkup($this->keyboard),
            MessengerKeyboardType::Reply => $this->makeReplyKeyboardMarkup($this->keyboard)
        };
    }

    protected function makeInlineKeyboardMarkup(MessengerKeyboardInterface $keyboard): InlineKeyboardMarkup
    {
        $inlineKeyboard = new InlineKeyboardMarkup();

        foreach ($keyboard->getRows() as $row) {
            $buttons = [];

            foreach ($row as $button) {
                $buttons[] = $this->makeInlineKeyboardButton($button);
            }

            $inlineKeyboard->addRow(...$buttons);
        }

        return $inlineKeyboard;
    }

    protected function makeReplyKeyboardMarkup(MessengerKeyboardInterface $keyboard): ReplyKeyboardMarkup
    {
        $replyKeyboard = new ReplyKeyboardMarkup(
            $keyboard->getOption(MessengerKeyboardOptionName::ResizeKeyboard->value)->getValue(),
            $keyboard->getOption(MessengerKeyboardOptionName::OneTimeKeyboard->value)->getValue(),
            $keyboard->getOption(MessengerKeyboardOptionName::InputFieldPlaceholder->value)->getValue(),
            $keyboard->getOption(MessengerKeyboardOptionName::Selective->value)->getValue(),
            $keyboard->getOption(MessengerKeyboardOptionName::IsPersistent->value)->getValue(),
        );

        foreach ($keyboard->getRows() as $row) {
            $buttons = [];

            foreach ($row as $button) {
                $buttons[] = $this->makeKeyboardButton($button);
            }

            $replyKeyboard->addRow(...$buttons);
        }

        return $replyKeyboard;
    }

    protected function makeInlineKeyboardButton(MessengerButtonInterfaceMessenger $button): InlineKeyboardButton
    {
        return new InlineKeyboardButton(
            $button->getText(),
            $button->getOption(MessengerButtonOptionName::Url->value)->getValue(),
            $button->getOption(MessengerButtonOptionName::LoginUrl->value)->getValue(),
            $button->getOption(MessengerButtonOptionName::CallbackData->value)->getValue(),
            $button->getOption(MessengerButtonOptionName::SwitchInlineQuery->value)->getValue(),
            $button->getOption(MessengerButtonOptionName::SwitchInlineQueryCurrentChat->value)->getValue(),
            $button->getOption(MessengerButtonOptionName::CallbackGame->value)->getValue(),
            $button->getOption(MessengerButtonOptionName::Pay->value)->getValue(),
            $button->getOption(MessengerButtonOptionName::WebApp->value)->getValue()
        );
    }

    protected function makeKeyboardButton(MessengerButtonInterfaceMessenger $button): KeyboardButton
    {
        return new KeyboardButton(
            $button->getText(),
            $button->getOption(MessengerButtonOptionName::RequestContact->value)->getValue(),
            $button->getOption(MessengerButtonOptionName::RequestLocation->value)->getValue(),
            $button->getOption(MessengerButtonOptionName::RequestPoll->value)->getValue(),
            $button->getOption(MessengerButtonOptionName::WebApp->value)->getValue(),
            $button->getOption(MessengerButtonOptionName::RequestUser->value)->getValue(),
            $button->getOption(MessengerButtonOptionName::RequestChat->value)->getValue()
        );
    }
}
