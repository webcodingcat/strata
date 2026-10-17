<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Buttons;

use WebCodingCat\WpAppFramework\Value\Link;
use WebCodingCat\WpAppFramework\Value\PlainText;

final readonly class ButtonAttributes
{
    public function __construct(
        #[PlainText]
        public string $label = '',
        public Link $link = new Link(),
        public ButtonStyle $variant = ButtonStyle::Primary,
    ) {}
}
