<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Copyright;

use WebCodingCat\WpAppFramework\Value\Label;
use WebCodingCat\WpAppFramework\Value\PlainText;

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
