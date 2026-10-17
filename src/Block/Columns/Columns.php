<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Columns;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Block\Section\Section;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Block\InnerBlocks;
use WebCodingCat\WpAppFramework\Block\Orientation;
use WebCodingCat\WpAppFramework\Block\Supports;
use WebCodingCat\WpAppFramework\Block\TemplateBlock;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * Two to four columns side by side on wide screens, one below the other on small ones.
 */
#[Block('columns', title: 'Columns', category: Category::Layout, icon: 'columns', ancestor: [Section::class])]
#[Supports(contentRole: true)]
#[InnerBlocks(allowed: [Column::class], template: [new TemplateBlock(Column::class), new TemplateBlock(Column::class)], orientation: Orientation::Horizontal, defaultBlock: new TemplateBlock(Column::class))]
final readonly class Columns
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(ColumnsAttributes $attrs, string $content): string
    {
        return $this->renderer->render('Block/Columns/Columns.twig', ['attrs' => $attrs, 'content' => $content]);
    }
}
