<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Section;

use WebCodingCat\WpAppFramework\Value\Labeled;

/**
 * How wide the content of a section is; the section itself always spans the whole window.
 */
enum SectionWidth: string implements Labeled
{
    case Narrow = 'narrow';
    case Normal = 'normal';
    case Wide = 'wide';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
