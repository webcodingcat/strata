<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Copyright;

use Saij\WpAppFramework\Value\Label;
use Saij\WpAppFramework\Value\PlainText;

final readonly class CopyrightAttributes
{
    public function __construct(
        #[PlainText]
        #[Label('Holder (empty: site title)')]
        public string $holder = '',
        #[Label('Since (year)')]
        public ?int $since = null,
    ) {}
}
