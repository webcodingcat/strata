<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Section;

use Saij\Strata\Block\Category;
use Saij\Strata\Scheme\ColorSchemeSupport;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Block\Support\UseSupport;
use Saij\WpAppFramework\Block\Supports;
use Saij\WpAppFramework\Twig\TemplateRenderer;

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
