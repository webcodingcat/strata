<?php

declare(strict_types=1);

namespace Saij\Strata\Scheme;

use Saij\WpAppFramework\Value\Color;
use Saij\WpAppFramework\Value\Identifier;
use Saij\WpAppFramework\Value\Label;
use Saij\WpAppFramework\Value\PlainText;

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
