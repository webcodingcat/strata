<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Scheme;

use WebCodingCat\WpAppFramework\Value\Color;
use WebCodingCat\WpAppFramework\Value\Identifier;
use WebCodingCat\WpAppFramework\Value\Label;
use WebCodingCat\WpAppFramework\Value\PlainText;

/**
 * A color scheme: background, foreground (text) and accent. A color left empty keeps the color of the scheme around
 * the block (the page scheme at the top).
 */
final readonly class ColorScheme
{
    public function __construct(
        #[Identifier]
        public string $id = '',
        #[PlainText]
        public string $name = '',
        #[Color]
        public string $background = '',
        #[Color]
        #[Label('Text')]
        public string $foreground = '',
        #[Color]
        public string $accent = '',
    ) {}
}
