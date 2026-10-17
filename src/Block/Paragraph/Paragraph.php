<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Paragraph;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Block\Section\Section;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Block\Supports;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * A paragraph; its text is stored in the post content.
 */
#[Block('paragraph', title: 'Paragraph', category: Category::Content, icon: 'editor-paragraph', keywords: ['text'], ancestor: [Section::class])]
#[Supports(anchor: true)]
final readonly class Paragraph
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(ParagraphAttributes $attrs): string
    {
        return $this->renderer->render('Block/Paragraph/Paragraph.twig', ['attrs' => $attrs]);
    }
}
