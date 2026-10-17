<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Group;

use WebCodingCat\WpAppFramework\Value\Labeled;

enum GroupLayout: string implements Labeled
{
    case Stack = 'stack';
    case Row = 'row';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
