<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerButton\Interface;

interface MessengerButtonFactoryInterface
{
    public function makeInlineButton(): MessengerButtonInterfaceMessenger;

    public function makeReplyButton(): MessengerButtonInterfaceMessenger;
}
