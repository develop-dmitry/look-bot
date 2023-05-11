<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler;

use Look\Application\Clothes\GetClothesForClient\GetClothesForClientRequest;
use Look\Application\Clothes\GetClothesForClient\Interface\GetClothesForClientInterface;
use Look\Application\Dictionary\DictionaryInterface;
use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonFactoryInterface;
use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonInterface;
use Look\Application\Messenger\MessengerContext\MessengerContextInterface;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerName;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerType;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerInterface;
use Look\Application\Messenger\MessengerKeyboard\Exception\FailedAddRowKeyboardException;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardFactoryInterface;
use Look\Application\Messenger\MessengerOption\Exception\FailedAddOptionException;
use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionNameException;
use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionValueException;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionFactoryInterface;
use Look\Application\Messenger\MessengerVisual\MessengerVisualInterface;
use Look\Domain\Clothes\Interface\ClothesPaginationInterface;
use Psr\Log\LoggerInterface;

class DressingRoomMessengerHandler implements MessengerHandlerInterface
{
    protected MessengerContextInterface $context;

    protected MessengerVisualInterface $visual;

    public function __construct(
        protected MessengerKeyboardFactoryInterface $keyboardFactory,
        protected MessengerButtonFactoryInterface $buttonFactory,
        protected MessengerOptionFactoryInterface $optionFactory,
        protected GetClothesForClientInterface $clothesForClient,
        protected DictionaryInterface $dictionary,
        protected LoggerInterface $logger
    ) {
    }

    public function handle(MessengerContextInterface $context, MessengerVisualInterface $visual): void
    {
        if (!$context->isIdentifiedClient()) {
            $visual->sendMessage($this->dictionary->getTranslate('telegram.unknown_client'));
            return;
        }

        $this->context = $context;
        $this->visual = $visual;

        $this->sendClothesSlider();
    }

    public function getTypes(): array
    {
        return [MessengerHandlerType::Text, MessengerHandlerType::CallbackQuery];
    }

    public function getNames(): array
    {
        return [MessengerHandlerName::DressingRoomText, MessengerHandlerName::DressingRoomCallbackQuery];
    }

    protected function sendClothesSlider(): void
    {
        $keyboard = $this->keyboardFactory->makeInlineKeyboard();

        $request = new GetClothesForClientRequest($this->context->getClient(), $this->getPage(), 1);
        $response = $this->clothesForClient->getClothesForClient($request);
        $clothesPagination = $response->getClothes();

        if (!$response->isSuccess() || empty($clothesPagination->getItems())) {
            $this->sendMessage($this->dictionary->getTranslate('common.dressing_room.empty_clothes'));
            return;
        }

        $clothes = $clothesPagination->getItems()[0];

        $this->sendMessage($clothes->getName()->getValue());

        /*foreach ($clothesPagination->getItems() as $item) {
            $text = (($item->isChosen()) ? '👉 ' : '') . $item->getName()->getValue();

            try {
                $button = $this->buttonFactory->makeCallbackDataInlineButton([
                    'action' => 'test'
                ])
                    ->setText($text);

                $keyboard->addRow($button);
            } catch (
                FailedAddRowKeyboardException|
                FailedAddOptionException|
                FailedSetOptionNameException|
                FailedSetOptionValueException $exception
            ) {
                $this->logger->emergency('Не удалось создать кнопку', [
                    'clothes' => (array) $item,
                    'exception' => $exception
                ]);
            }
        }*/

        $navButtons = [];

        try {
            if ($clothesPagination->hasPrev()) {
                $navButtons[] = $this->makeNavButton('Назад', $clothesPagination->getPage() - 1);
            }

            if ($clothesPagination->hasNext()) {
                $navButtons[] = $this->makeNavButton('Вперед', $clothesPagination->getPage() + 1);
            }

            $keyboard->addRow(...$navButtons);
        } catch (
            FailedAddRowKeyboardException|
            FailedAddOptionException|
            FailedSetOptionNameException|
            FailedSetOptionValueException $exception
        ) {
            $this->logger->emergency('Не удалось создать кнопку', ['exception' => $exception]);
        }

        //$this->sendMessage($this->dictionary->getTranslate('telegram.dressing_room.choose_clothes'));
        $this->visual->sendKeyboard($keyboard);
    }

    protected function sendMessage(string $message): void
    {
        $callbackQuery = $this->context->getRequest()->getCallbackQuery();

        $this->visual->sendMessage($message, $callbackQuery['edit'] ?? false);
    }

    /**
     * @throws FailedSetOptionNameException
     * @throws FailedAddOptionException
     * @throws FailedSetOptionValueException
     */
    protected function makeNavButton(string $text, int $page): MessengerButtonInterface
    {
        return $this->buttonFactory->makeCallbackDataInlineButton([
                'action' => MessengerHandlerName::DressingRoomCallbackQuery->value,
                'page' => $page,
                'edit' => true
            ])
            ->setText($text);
    }

    protected function getPage(): int
    {
        $callbackQuery = $this->context->getRequest()->getCallbackQuery();

        return $callbackQuery['page'] ?? 1;
    }
}
