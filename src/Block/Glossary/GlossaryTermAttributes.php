<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Glossary;

use Saij\WpAppFramework\Value\PlainText;
use Saij\WpAppFramework\Value\RichText;

final readonly class GlossaryTermAttributes
{
    public function __construct(
        #[PlainText]
        public string $term = '',
        #[RichText(postContent: true, allowedFormats: ['core/bold', 'core/italic', 'core/link'])]
        public string $explanation = '',
    ) {}
}
