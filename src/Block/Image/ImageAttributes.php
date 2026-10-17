<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Image;

use WebCodingCat\WpAppFramework\Value\Image;
use WebCodingCat\WpAppFramework\Value\Label;
use WebCodingCat\WpAppFramework\Value\Link;
use WebCodingCat\WpAppFramework\Value\RichText;

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
