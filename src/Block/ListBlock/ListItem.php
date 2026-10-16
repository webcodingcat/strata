<?php

declare(strict_types=1);

namespace Saij\Strata\Block\ListBlock;

use Saij\Strata\Block\Category;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Twig\TemplateRenderer;

/**
 * An item of a list; its text is stored in the post content.
 */
#[Block('list-item', title: 'List item', category: Category::Content, icon: 'minus', parent: [ListBlock::class])]
final readonly class ListItem
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(ListItemAttributes $attrs): string
    {
        return $this->renderer->render('Block/ListBlock/ListItem.twig', ['attrs' => $attrs]);
    }
}
