<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Image;

use Saij\WpAppFramework\Value\Image;
use Saij\WpAppFramework\Value\Label;
use Saij\WpAppFramework\Value\Link;
use Saij\WpAppFramework\Value\RichText;

final readonly class ImageAttributes
{
    public function __construct(
        #[Image]
        #[Label('Image')]
        public ?int $imageId = null,
        #[RichText(allowedFormats: ['core/bold', 'core/italic', 'core/link'])]
        public string $caption = '',
        public Link $link = new Link(),
        public bool $rounded = true,
    ) {}
}
