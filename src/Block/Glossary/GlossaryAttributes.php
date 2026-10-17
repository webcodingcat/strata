<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Glossary;

use Saij\WpAppFramework\Value\Label;
use Saij\WpAppFramework\Value\PlainText;

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
