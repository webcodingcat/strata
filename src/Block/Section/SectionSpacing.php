<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Section;

use WebCodingCat\WpAppFramework\Value\Labeled;

/**
 * The space above and below the content of a section.
 */
enum SectionSpacing: string implements Labeled
{
    case None = 'none';
    case Compact = 'compact';
    case Normal = 'normal';
    case Spacious = 'spacious';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
