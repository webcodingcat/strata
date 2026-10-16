<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Heading;

use Saij\Strata\Block\Text\TextAlign;
use Saij\WpAppFramework\Value\RichText;

final readonly class HeadingAttributes
{
    public function __construct(
        #[RichText(allowedFormats: ['core/bold', 'core/italic', 'core/link'], postContent: true, excerpt: true)]
        public string $text = '',
        public HeadingLevel $level = HeadingLevel::Two,
        public TextAlign $textAlign = TextAlign::Start,
    ) {}
}
