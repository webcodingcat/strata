<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Columns;

use Saij\Strata\Block\Category;
use Saij\Strata\Scheme\ColorSchemeSupport;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Block\Support\UseSupport;
use Saij\WpAppFramework\Block\Supports;
use Saij\WpAppFramework\Twig\TemplateRenderer;

/**
 * One column of a columns block.
 */
#[Block('column', title: 'Column', category: Category::Layout, icon: 'column', parent: [Columns::class])]
#[Supports(contentRole: true)]
#[UseSupport(ColorSchemeSupport::class)]
final readonly class Column
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(ColumnAttributes $attrs, string $content): string
    {
        return $this->renderer->render('Block/Columns/Column.twig', ['attrs' => $attrs, 'content' => $content]);
    }
}
