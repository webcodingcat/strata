<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Group;

use WebCodingCat\WpAppFramework\Value\Labeled;

/**
 * How the blocks of a group line up across its direction.
 */
enum GroupAlign: string implements Labeled
{
    case Stretch = 'stretch';
    case Start = 'start';
    case Center = 'center';
    case End = 'end';
    case Baseline = 'baseline';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
