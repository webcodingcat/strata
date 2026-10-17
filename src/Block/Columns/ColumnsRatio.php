<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Columns;

use WebCodingCat\WpAppFramework\Value\Labeled;

/**
 * How the width is shared between the columns on wide screens; below, the columns stack.
 */
enum ColumnsRatio: string implements Labeled
{
    case Equal = 'equal';
    case WideStart = 'wide-start';
    case WideEnd = 'wide-end';

    public function label(): string
    {
        return match ($this) {
            self::Equal => 'Equal',
            self::WideStart => 'First column wider (2 : 1)',
            self::WideEnd => 'Last column wider (1 : 2)',
        };
    }
}
