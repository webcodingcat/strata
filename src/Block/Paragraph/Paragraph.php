<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Paragraph;

use Saij\Strata\Block\Category;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Block\Supports;
use Saij\WpAppFramework\Twig\TemplateRenderer;

/**
 * A paragraph; its text is stored in the post content.
 */
#[Block('paragraph', title: 'Paragraph', category: Category::Content, icon: 'editor-paragraph', keywords: ['text'])]
#[Supports(anchor: true)]
final readonly class Paragraph
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(ParagraphAttributes $attrs): string
    {
        return $this->renderer->render('Block/Paragraph/Paragraph.twig', ['attrs' => $attrs]);
    }
}
