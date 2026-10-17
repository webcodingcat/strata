<?php

declare(strict_types=1);

namespace Saij\Strata\Block\ListBlock;

use Saij\Strata\Block\Category;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Block\InnerBlocks;
use Saij\WpAppFramework\Block\Supports;
use Saij\WpAppFramework\Block\TemplateBlock;
use Saij\WpAppFramework\Twig\TemplateRenderer;

/**
 * A bulleted or numbered list of list items; an item holds a paragraph and, for a nested list, a list.
 */
#[Block('list', title: 'List', category: Category::Content, icon: 'editor-ul', excerptWrapper: true)]
#[Supports(anchor: true)]
#[InnerBlocks(allowed: [ListItem::class], template: [new TemplateBlock(ListItem::class)], defaultBlock: new TemplateBlock(ListItem::class), directInsert: true)]
final readonly class ListBlock
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(ListAttributes $attrs, string $content): string
    {
        return $this->renderer->render('Block/ListBlock/ListBlock.twig', ['attrs' => $attrs, 'content' => $content]);
    }
}
