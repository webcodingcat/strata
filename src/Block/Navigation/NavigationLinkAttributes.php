<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Navigation;

use Saij\WpAppFramework\Value\Link;
use Saij\WpAppFramework\Value\PlainText;

final readonly class NavigationLinkAttributes
{
    public function __construct(
        #[PlainText]
        public string $label = '',
        public Link $link = new Link(),
    ) {}
}
