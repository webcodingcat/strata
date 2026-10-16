<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Query;

use Saij\WpAppFramework\Value\Labeled;

/**
 * Which posts a query shows: those of the page (an archive, the search, the blog) or the latest posts.
 */
enum QuerySource: string implements Labeled
{
    case Page = 'page';
    case Latest = 'latest';

    public function label(): string
    {
        return match ($this) {
            self::Page => 'Posts of the page (archive, search, blog)',
            self::Latest => 'Latest posts',
        };
    }
}
