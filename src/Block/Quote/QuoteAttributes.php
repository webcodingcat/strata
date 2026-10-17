<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Quote;

use WebCodingCat\WpAppFramework\Value\Label;
use WebCodingCat\WpAppFramework\Value\PlainText;
use WebCodingCat\WpAppFramework\Value\RichText;

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
