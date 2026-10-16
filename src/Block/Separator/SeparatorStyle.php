<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Separator;

use Saij\WpAppFramework\Value\Labeled;

enum SeparatorStyle: string implements Labeled
{
    case Line = 'line';
    case Short = 'short';
    case Space = 'space';

    public function label(): string
    {
        return match ($this) {
            self::Line => 'Line',
            self::Short => 'Short line',
            self::Space => 'Space only',
        };
    }
}
