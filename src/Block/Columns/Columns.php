<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Columns;

use Saij\Strata\Block\Category;
use Saij\Strata\Block\Section\Section;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Block\InnerBlocks;
use Saij\WpAppFramework\Block\Orientation;
use Saij\WpAppFramework\Block\Supports;
use Saij\WpAppFramework\Block\TemplateBlock;
use Saij\WpAppFramework\Twig\TemplateRenderer;

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
