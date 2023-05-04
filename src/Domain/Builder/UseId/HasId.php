<?php

declare(strict_types=1);

namespace Look\Domain\Builder\UseId;

trait HasId
{
    public function setId(?int $id): static
    {
        $this->values['id'] = $id;
        return $this;
    }
}
