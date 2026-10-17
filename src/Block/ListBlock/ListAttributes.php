<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\ListBlock;

final readonly class ListAttributes
{
    public function __construct(
        public bool $ordered = false,
    ) {}
}
