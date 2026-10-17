<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Quote;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Block\Section\Section;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Block\Supports;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * A quotation with its source; the text is stored in the post content.
 */
#[Block('quote', title: 'Quote', category: Category::Content, icon: 'format-quote', keywords: ['citation', 'testimonial'], ancestor: [Section::class])]
#[Supports(anchor: true)]
final readonly class Quote
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(QuoteAttributes $attrs): string
    {
        return $this->renderer->render('Block/Quote/Quote.twig', ['attrs' => $attrs]);
    }
}
