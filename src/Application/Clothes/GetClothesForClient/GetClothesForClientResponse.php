<?php

declare(strict_types=1);

namespace Look\Application\Clothes\GetClothesForClient;

use Look\Application\Clothes\GetClothesForClient\Interface\GetClothesForClientResponseInterface;
use Look\Domain\Clothes\Interface\ClothesPaginationInterface;

class GetClothesForClientResponse implements GetClothesForClientResponseInterface
{
    /**
     * @param bool $isSuccess
     * @param ClothesPaginationInterface $clothes
     * @param string $error
     */
    public function __construct(
        protected bool $isSuccess,
        protected ClothesPaginationInterface $clothes,
        protected string $error = ''
    ) {
    }

    public function getClothes(): ClothesPaginationInterface
    {
        return $this->clothes;
    }

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    public function getError(): string
    {
        return $this->error;
    }
}
