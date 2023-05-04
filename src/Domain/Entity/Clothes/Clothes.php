<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Clothes;

use Look\Domain\Entity\Clothes\Interface\ClothesInterface;
use Look\Domain\Entity\Event\Interface\EventRepositoryInterface;
use Look\Domain\Entity\Season\Interface\SeasonInterface;
use Look\Domain\Entity\Season\Interface\SeasonRepositoryInterface;
use Look\Domain\Entity\Style\Interface\StyleRepositoryInterface;
use Look\Domain\Property\UseEvent\HasEvent;
use Look\Domain\Property\UseId\HasId;
use Look\Domain\Property\UseName\HasName;
use Look\Domain\Property\UsePhoto\HasPhoto;
use Look\Domain\Property\UseStyle\HasStyle;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class Clothes implements ClothesInterface
{
    use HasId, HasName, HasPhoto, HasStyle, HasEvent;

    /**
     * @var SeasonInterface[]
     */
    protected array $seasons = [];

    /**
     * @var int[]
     */
    protected array $getSeasonsQueue = [];

    public function __construct(
        protected ValueFactoryInterface $valueFactory,
        protected StyleRepositoryInterface $styleRepository,
        protected EventRepositoryInterface $eventRepository,
        protected SeasonRepositoryInterface $seasonRepository
    ) {
    }

    public function addSeasons(int ...$seasonPrimary): static
    {
        $this->getSeasonsQueue = array_merge($this->getSeasonsQueue, $seasonPrimary);
        return $this;
    }

    public function getSeasons(): array
    {
        if (!empty($this->getSeasonsQueue)) {
            foreach ($this->seasonRepository->getItemsById($this->getSeasonsQueue) as $season) {
                $this->seasons[] = $season;
            }

            $this->getSeasonsQueue = [];
        }

        return $this->seasons;
    }
}
