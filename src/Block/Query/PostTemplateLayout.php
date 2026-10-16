<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Query;

use Saij\WpAppFramework\Value\Labeled;

enum PostTemplateLayout: string implements Labeled
{
    case List = 'list';
    case Grid = 'grid';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
