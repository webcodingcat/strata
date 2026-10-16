<?php

declare(strict_types=1);

namespace Saij\Strata\Block;

use Saij\WpAppFramework\Block\CustomBlockCategory;

/**
 * The block categories of the theme in the inserter.
 */
enum Category: string implements CustomBlockCategory
{
    case Layout = 'layout';
    case Content = 'content';

    public function label(): string
    {
        return match ($this) {
            self::Layout => 'Layout',
            self::Content => 'Content',
        };
    }

    public function icon(): ?string
    {
        return null;
    }
}
