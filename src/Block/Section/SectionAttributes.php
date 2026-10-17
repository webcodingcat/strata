<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Section;

final readonly class SectionAttributes
{
    public function __construct(
        public SectionWidth $width = SectionWidth::Normal,
        public SectionSpacing $spacing = SectionSpacing::Normal,
    ) {}
}
