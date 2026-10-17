<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Separator;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Block\Section\Section;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * A break between parts of the content: a line, a short line or space only.
 */
#[Block('separator', title: 'Separator', category: Category::Layout, icon: 'minus', keywords: ['divider', 'line', 'hr'], ancestor: [Section::class])]
final readonly class Separator
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(SeparatorAttributes $attrs): string
    {
        return $this->renderer->render('Block/Separator/Separator.twig', ['attrs' => $attrs]);
    }
}
