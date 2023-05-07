<?php

declare(strict_types=1);

namespace Look\Application\Dictionary;

class Dictionary implements DictionaryInterface
{
    public function __construct(
        protected string $locale
    ) {
    }

    public function getTranslate(string $key, array $replace = []): string
    {
        return __($key, $replace, $this->locale);
    }
}
