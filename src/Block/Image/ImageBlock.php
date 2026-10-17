<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Image;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Block\Section\Section;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Block\Supports;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * An image of the media library with a caption, optionally linked.
 */
#[Block('image', title: 'Image', category: Category::Content, icon: 'format-image', keywords: ['photo', 'picture'], ancestor: [Section::class])]
#[Supports(anchor: true)]
final readonly class ImageBlock
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(ImageAttributes $attrs): string
    {
        return $this->renderer->render('Block/Image/ImageBlock.twig', ['attrs' => $attrs]);
    }
}
