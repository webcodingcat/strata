<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Heading;

use Saij\Strata\Block\Category;
use Saij\Strata\Block\Section\Section;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Block\Supports;
use Saij\WpAppFramework\Twig\TemplateRenderer;

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
