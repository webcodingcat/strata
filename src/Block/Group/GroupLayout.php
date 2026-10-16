<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Group;

use Saij\WpAppFramework\Value\Labeled;

enum GroupLayout: string implements Labeled
{
    case Stack = 'stack';
    case Row = 'row';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
