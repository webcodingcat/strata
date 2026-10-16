<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Section;

use Saij\WpAppFramework\Value\Labeled;

/**
 * The HTML element of a section: a section of the page by default, a plain div inside header and footer.
 */
enum SectionElement: string implements Labeled
{
    case Section = 'section';
    case Div = 'div';
    case Aside = 'aside';

    public function label(): string
    {
        return match ($this) {
            self::Section => 'Section',
            self::Div => 'Plain (div)',
            self::Aside => 'Aside',
        };
    }
}
