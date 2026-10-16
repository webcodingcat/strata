<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Query;

use Saij\Strata\Block\Category;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Block\InnerBlocks;
use Saij\WpAppFramework\Block\Supports;
use Saij\WpAppFramework\Block\TemplateBlock;
use Saij\WpAppFramework\Twig\TemplateRenderer;

/**
 * A list of posts: the posts of the page or the latest ones, shown by its post template, with pagination.
 */
#[Block('query', title: 'Posts', category: Category::Layout, icon: 'grid-view', description: 'A list of posts: those of the page or the latest ones.', keywords: ['query', 'loop', 'blog'])]
#[Supports(contentRole: true, anchor: true)]
#[InnerBlocks(allowed: [PostTemplate::class, Pagination::class], template: [new TemplateBlock(PostTemplate::class), new TemplateBlock(Pagination::class)])]
final readonly class Query
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(QueryAttributes $attrs, string $content): string
    {
        return $this->renderer->render('Block/Query/Query.twig', ['attrs' => $attrs, 'content' => $content]);
    }
}
