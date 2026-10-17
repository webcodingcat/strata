<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Facts;

use WebCodingCat\WpAppFramework\Value\Label;

final readonly class FactsAttributes
{
    public function __construct(
        #[Label('Show as boxes')]
        public bool $boxed = false,
    ) {}
}
