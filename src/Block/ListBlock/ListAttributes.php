<?php

declare(strict_types=1);

namespace Saij\Strata\Block\ListBlock;

final readonly class ListAttributes
{
    public function __construct(
        public bool $ordered = false,
    ) {}
}
