<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Paragraph;

use Saij\Strata\Block\Text\TextAlign;
use Saij\Strata\Block\Text\TextSize;
use Saij\WpAppFramework\Value\RichText;

final readonly class ParagraphAttributes
{
    public function __construct(
        #[RichText(postContent: true, excerpt: true)]
        public string $text = '',
        public TextSize $size = TextSize::Normal,
        public TextAlign $textAlign = TextAlign::Start,
    ) {}
}
