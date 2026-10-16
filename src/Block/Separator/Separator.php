<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Separator;

use Saij\Strata\Block\Category;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Twig\TemplateRenderer;

/**
 * A break between parts of the content: a line, a short line or space only.
 */
#[Block('separator', title: 'Separator', category: Category::Layout, icon: 'minus', keywords: ['divider', 'line', 'hr'])]
final readonly class Separator
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(SeparatorAttributes $attrs): string
    {
        return $this->renderer->render('Block/Separator/Separator.twig', ['attrs' => $attrs]);
    }
}
