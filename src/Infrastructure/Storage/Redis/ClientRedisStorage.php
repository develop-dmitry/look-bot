<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Redis;

class ClientRedisStorage extends AbstractRedisStorage
{
    protected string $entity = 'client';
}
