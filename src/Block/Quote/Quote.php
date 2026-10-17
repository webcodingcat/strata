<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Quote;

use Saij\Strata\Block\Category;
use Saij\Strata\Block\Section\Section;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Block\Supports;
use Saij\WpAppFramework\Twig\TemplateRenderer;

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
