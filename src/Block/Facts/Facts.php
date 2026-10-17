<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Facts;

use Saij\Strata\Block\Category;
use Saij\Strata\Block\Section\Section;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Block\InnerBlocks;
use Saij\WpAppFramework\Block\Orientation;
use Saij\WpAppFramework\Block\Supports;
use Saij\WpAppFramework\Block\TemplateBlock;
use Saij\WpAppFramework\Twig\TemplateRenderer;

/**
 * Key facts at a glance – opening hours, a place, a date – side by side as far as they fit, optionally as boxes.
 */
#[Block('facts', title: 'Facts', category: Category::Content, icon: 'info-outline', description: 'Key facts with an icon, a label and a value.', keywords: ['info', 'details', 'opening hours'], ancestor: [Section::class])]
#[Supports(contentRole: true)]
#[InnerBlocks(allowed: [Fact::class], template: [new TemplateBlock(Fact::class)], orientation: Orientation::Horizontal, defaultBlock: new TemplateBlock(Fact::class), directInsert: true)]
final readonly class Facts
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(FactsAttributes $attrs, string $content): string
    {
        return $this->renderer->render('Block/Facts/Facts.twig', ['attrs' => $attrs, 'content' => $content]);
    }
}
