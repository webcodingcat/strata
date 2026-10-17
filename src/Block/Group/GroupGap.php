<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Group;

use WebCodingCat\WpAppFramework\Value\Labeled;

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
