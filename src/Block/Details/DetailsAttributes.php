<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Details;

use Saij\WpAppFramework\Value\Label;
use Saij\WpAppFramework\Value\PlainText;

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
