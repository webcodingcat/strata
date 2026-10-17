<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Section;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Scheme\ColorSchemeSupport;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Block\Support\UseSupport;
use WebCodingCat\WpAppFramework\Block\Supports;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * A part of the page across the whole window: its content limited to a width, with a color scheme.
 */
#[Block('section', title: 'Section', category: Category::Layout, icon: 'align-full-width', description: 'A part of the page across the whole window, with a color scheme and a content width.')]
#[Supports(contentRole: true, anchor: true)]
#[UseSupport(ColorSchemeSupport::class)]
final readonly class Section
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(SectionAttributes $attrs, string $content): string
    {
        return $this->renderer->render('Block/Section/Section.twig', ['attrs' => $attrs, 'content' => $content]);
    }
}
