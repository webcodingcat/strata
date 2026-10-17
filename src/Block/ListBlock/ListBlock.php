<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\ListBlock;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Block\Section\Section;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Block\InnerBlocks;
use WebCodingCat\WpAppFramework\Block\Supports;
use WebCodingCat\WpAppFramework\Block\TemplateBlock;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * A bulleted or numbered list of list items; an item holds a paragraph and, for a nested list, a list.
 */
#[Block('list', title: 'List', category: Category::Content, icon: 'editor-ul', excerptWrapper: true, ancestor: [Section::class])]
#[Supports(contentRole: true, anchor: true)]
#[InnerBlocks(allowed: [ListItem::class], template: [new TemplateBlock(ListItem::class)], defaultBlock: new TemplateBlock(ListItem::class), directInsert: true)]
final readonly class ListBlock
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(ListAttributes $attrs, string $content): string
    {
        return $this->renderer->render('Block/ListBlock/ListBlock.twig', ['attrs' => $attrs, 'content' => $content]);
    }
}
