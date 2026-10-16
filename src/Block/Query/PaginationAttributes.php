<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Query;

use Saij\WpAppFramework\Value\Label;
use Saij\WpAppFramework\Value\PlainText;

final readonly class PaginationAttributes
{
    public function __construct(
        #[PlainText(inspector: true)]
        #[Label('Previous')]
        public string $previous = 'Newer posts',
        #[PlainText(inspector: true)]
        #[Label('Next')]
        public string $next = 'Older posts',
    ) {}
}
