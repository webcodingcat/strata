<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Query;

use Saij\WpAppFramework\Block\ProvidesContext;
use Saij\WpAppFramework\Value\Label;

final readonly class QueryAttributes
{
    public function __construct(
        #[ProvidesContext]
        public QuerySource $source = QuerySource::Page,
        #[ProvidesContext]
        #[Label('Number of latest posts')]
        public int $count = 6,
    ) {}
}
