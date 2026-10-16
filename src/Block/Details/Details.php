<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Details;

use Saij\Strata\Block\Category;
use Saij\Strata\Block\Paragraph\Paragraph;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Block\InnerBlocks;
use Saij\WpAppFramework\Block\Supports;
use Saij\WpAppFramework\Block\TemplateBlock;
use Saij\WpAppFramework\Twig\TemplateRenderer;

/**
 * A summary that opens to its content, e.g. a question of a FAQ. In the editor it is always open.
 */
#[Block('details', title: 'Details', category: Category::Content, icon: 'arrow-down-alt2', keywords: ['faq', 'accordion', 'toggle'], excerptWrapper: true)]
#[Supports(anchor: true)]
#[InnerBlocks(template: [new TemplateBlock(Paragraph::class)])]
final readonly class Details
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(DetailsAttributes $attrs, string $content): string
    {
        return $this->renderer->render('Block/Details/Details.twig', ['attrs' => $attrs, 'content' => $content]);
    }
}
