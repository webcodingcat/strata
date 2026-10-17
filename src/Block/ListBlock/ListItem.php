<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\ListBlock;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Block\Paragraph\Paragraph;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Block\InnerBlocks;
use WebCodingCat\WpAppFramework\Block\Supports;
use WebCodingCat\WpAppFramework\Block\TemplateBlock;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

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
