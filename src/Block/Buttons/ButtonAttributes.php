<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Buttons;

use Saij\WpAppFramework\Value\Link;
use Saij\WpAppFramework\Value\PlainText;

final readonly class ButtonAttributes
{
    public function __construct(
        #[PlainText]
        public string $label = '',
        public Link $link = new Link(),
        public ButtonStyle $variant = ButtonStyle::Primary,
    ) {}
}
