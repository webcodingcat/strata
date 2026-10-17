<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Navigation;

use Saij\WpAppFramework\Value\Label;
use Saij\WpAppFramework\Value\PlainText;

final readonly class NavigationAttributes
{
    public function __construct(
        #[PlainText(inspector: true)]
        #[Label('Name for screen readers')]
        public string $label = 'Main',
        #[PlainText(inspector: true)]
        #[Label('Menu button')]
        public string $menuLabel = 'Menu',
        #[PlainText(inspector: true)]
        #[Label('Close button (for screen readers)')]
        public string $closeLabel = 'Close menu',
        public NavigationJustify $justify = NavigationJustify::End,
    ) {}
}
