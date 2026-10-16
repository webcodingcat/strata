<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Query;

use Saij\Strata\Block\Category;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Block\Context;
use Saij\WpAppFramework\Block\CoreBlock;
use Saij\WpAppFramework\Block\InnerBlocks;
use Saij\WpAppFramework\Block\Repeater;
use Saij\WpAppFramework\Block\TemplateBlock;
use Saij\WpAppFramework\Twig\TemplateRenderer;

/**
 * The design of one post in a query, repeated for each post (Repeater).
 */
#[Block('post-template', title: 'Post template', category: Category::Layout, icon: 'layout', parent: [Query::class])]
#[InnerBlocks(template: [
    new TemplateBlock(CoreBlock::PostTitle, ['isLink' => true, 'level' => 2]),
    new TemplateBlock(CoreBlock::PostDate),
    new TemplateBlock(CoreBlock::PostExcerpt),
])]
final readonly class PostTemplate
{
    public function __construct(
        private TemplateRenderer $renderer,
        private QueryPosts $posts,
    ) {}

    public function render(
        PostTemplateAttributes $attrs,
        Repeater $repeater,
        #[Context(Query::class, 'source')]
        QuerySource $source = QuerySource::Page,
        #[Context(Query::class, 'count')]
        int $count = 6,
    ): string {
        return $this->renderer->render('Block/Query/PostTemplate.twig', [
            'attrs' => $attrs,
            'items' => array_map($repeater->post(...), $this->posts->posts($source, $count)),
        ]);
    }
}
