<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Columns;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Scheme\ColorSchemeSupport;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Block\Support\UseSupport;
use WebCodingCat\WpAppFramework\Block\Supports;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

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
