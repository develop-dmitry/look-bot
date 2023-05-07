<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerButton\Interface;

use Look\Application\Messenger\MessengerOption\Exception\FailedAddOptionException;
use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionNameException;
use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionValueException;

interface MessengerButtonFactoryInterface
{
    /**
     * @return MessengerButtonInterface
     */
    public function makeInlineButton(): MessengerButtonInterface;

    /**
     * @return MessengerButtonInterface
     */
    public function makeReplyButton(): MessengerButtonInterface;

    /**
     * @return MessengerButtonInterface
     * @throws FailedSetOptionNameException
     * @throws FailedAddOptionException
     * @throws FailedSetOptionValueException
     */
    public function makeLocationReplyButton(): MessengerButtonInterface;

    /**
     * @param array $callbackData
     * @return MessengerButtonInterface
     * @throws FailedSetOptionNameException
     * @throws FailedAddOptionException
     * @throws FailedSetOptionValueException
     */
    public function makeCallbackDataInlineButton(array $callbackData): MessengerButtonInterface;
}
