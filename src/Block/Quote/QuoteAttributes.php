<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Quote;

use Saij\WpAppFramework\Value\Label;
use Saij\WpAppFramework\Value\PlainText;
use Saij\WpAppFramework\Value\RichText;

final readonly class QuoteAttributes
{
    public function __construct(
        #[RichText(allowedFormats: ['core/bold', 'core/italic', 'core/link'], postContent: true, excerpt: true)]
        public string $text = '',
        #[PlainText]
        #[Label('Source')]
        public string $citation = '',
    ) {}
}
