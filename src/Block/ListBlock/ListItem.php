<?php

declare(strict_types=1);

namespace Saij\Strata\Block\ListBlock;

use Saij\Strata\Block\Category;
use Saij\Strata\Block\Paragraph\Paragraph;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Block\InnerBlocks;
use Saij\WpAppFramework\Block\Supports;
use Saij\WpAppFramework\Block\TemplateBlock;
use Saij\WpAppFramework\Twig\TemplateRenderer;

/**
 * An item of a list: its content are blocks – a paragraph for the text, and a list inside for a nested list.
 */
#[Block('list-item', title: 'List item', category: Category::Content, icon: 'minus', parent: [ListBlock::class], excerptWrapper: true)]
#[Supports(contentRole: true)]
#[InnerBlocks(
    allowed: [Paragraph::class, ListBlock::class],
    template: [new TemplateBlock(Paragraph::class)],
    defaultBlock: new TemplateBlock(Paragraph::class),
)]
final readonly class ListItem
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(string $content): string
    {
        return $this->renderer->render('Block/ListBlock/ListItem.twig', ['content' => $content]);
    }
}
