<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Glossary;

use WebCodingCat\WpAppFramework\Value\Label;
use WebCodingCat\WpAppFramework\Value\PlainText;

final readonly class GlossaryAttributes
{
    public function __construct(
        #[Label('Show the index A–Z')]
        public bool $index = true,
        #[PlainText(inspector: true)]
        #[Label('Name of the index for screen readers')]
        public string $indexLabel = 'Index',
    ) {}
}
