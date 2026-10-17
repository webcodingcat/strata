<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Facts;

use Saij\WpAppFramework\Value\Label;

final readonly class FactsAttributes
{
    public function __construct(
        #[Label('Show as boxes')]
        public bool $boxed = false,
    ) {}
}
