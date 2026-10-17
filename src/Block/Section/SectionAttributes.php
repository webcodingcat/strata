<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Section;

use Saij\WpAppFramework\Value\Hidden;

final readonly class SectionAttributes
{
    public function __construct(
        public SectionWidth $width = SectionWidth::Normal,
        public SectionSpacing $spacing = SectionSpacing::Normal,
        // Set by the templates and parts (main, div); editors need no choice.
        #[Hidden]
        public SectionElement $element = SectionElement::Section,
    ) {}
}
