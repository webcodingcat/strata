<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Navigation;

use WebCodingCat\WpAppFramework\Value\Labeled;

/**
 * Where the row of links sits from `md` on; in the panel of small screens they stand one below the other.
 */
enum NavigationJustify: string implements Labeled
{
    case Start = 'start';
    case Center = 'center';
    case End = 'end';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
