<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Details;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Block\Paragraph\Paragraph;
use WebCodingCat\Strata\Block\Section\Section;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Block\InnerBlocks;
use WebCodingCat\WpAppFramework\Block\Supports;
use WebCodingCat\WpAppFramework\Block\TemplateBlock;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * A summary that opens to its content, e.g. a question of a FAQ. In the editor it is always open.
 */
#[Block('details', title: 'Details', category: Category::Content, icon: 'arrow-down-alt2', keywords: ['faq', 'accordion', 'toggle'], excerptWrapper: true, ancestor: [Section::class])]
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
