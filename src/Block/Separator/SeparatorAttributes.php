<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Separator;

final readonly class SeparatorAttributes
{
    public function __construct(
        public SeparatorStyle $variant = SeparatorStyle::Line,
    ) {}
}
