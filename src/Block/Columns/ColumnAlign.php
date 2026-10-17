<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Columns;

use WebCodingCat\WpAppFramework\Value\Labeled;

enum ColumnAlign: string implements Labeled
{
    case Start = 'start';
    case Center = 'center';
    case End = 'end';

    public function label(): string
    {
        return match ($this) {
            self::Start => 'Top',
            self::Center => 'Middle',
            self::End => 'Bottom',
        };
    }
}
