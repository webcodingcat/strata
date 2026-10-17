<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Details;

use WebCodingCat\WpAppFramework\Value\Label;
use WebCodingCat\WpAppFramework\Value\PlainText;

final readonly class DetailsAttributes
{
    public function __construct(
        #[PlainText]
        #[Label('Summary')]
        public string $summary = '',
        #[Label('Open at first')]
        public bool $open = false,
    ) {}
}
