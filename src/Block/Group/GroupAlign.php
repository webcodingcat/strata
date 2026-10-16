<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Group;

use Saij\WpAppFramework\Value\Labeled;

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
