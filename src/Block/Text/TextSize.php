<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Text;

use Saij\WpAppFramework\Value\Labeled;

enum TextSize: string implements Labeled
{
    case Small = 'small';
    case Normal = 'normal';
    case Lead = 'lead';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
