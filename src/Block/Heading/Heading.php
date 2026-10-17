<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Heading;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Block\Section\Section;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Block\Supports;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * A heading of level 1 to 4; its text is stored in the post content.
 */
#[Block('heading', title: 'Heading', category: Category::Content, icon: 'heading', keywords: ['title'], ancestor: [Section::class])]
#[Supports(anchor: true)]
final readonly class Heading
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(HeadingAttributes $attrs): string
    {
        return $this->renderer->render('Block/Heading/Heading.twig', ['attrs' => $attrs]);
    }
}
