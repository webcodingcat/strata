<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Paragraph;

use WebCodingCat\Strata\Block\Text\TextAlign;
use WebCodingCat\Strata\Block\Text\TextSize;
use WebCodingCat\WpAppFramework\Value\RichText;

final readonly class ParagraphAttributes
{
    public function __construct(
        #[RichText(postContent: true, excerpt: true)]
        public string $text = '',
        public TextSize $size = TextSize::Normal,
        public TextAlign $textAlign = TextAlign::Start,
    ) {}
}
