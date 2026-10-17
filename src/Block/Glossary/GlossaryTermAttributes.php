<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Glossary;

use WebCodingCat\WpAppFramework\Value\PlainText;
use WebCodingCat\WpAppFramework\Value\RichText;

final readonly class GlossaryTermAttributes
{
    public function __construct(
        #[PlainText]
        public string $term = '',
        #[RichText(postContent: true, allowedFormats: ['core/bold', 'core/italic', 'core/link'])]
        public string $explanation = '',
    ) {}
}
