<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Group;

use Saij\WpAppFramework\Value\Labeled;

enum GroupGap: string implements Labeled
{
    case None = 'none';
    case Small = 'small';
    case Normal = 'normal';
    case Large = 'large';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
