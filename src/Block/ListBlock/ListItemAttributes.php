<?php

declare(strict_types=1);

namespace Saij\Strata\Block\ListBlock;

use Saij\WpAppFramework\Value\RichText;

final readonly class ListItemAttributes
{
    public function __construct(
        #[RichText(postContent: true, excerpt: true)]
        public string $text = '',
    ) {}
}
