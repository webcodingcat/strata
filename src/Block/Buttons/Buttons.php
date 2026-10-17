<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Buttons;

use Saij\Strata\Block\Category;
use Saij\Strata\Block\Section\Section;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Block\InnerBlocks;
use Saij\WpAppFramework\Block\Orientation;
use Saij\WpAppFramework\Block\Supports;
use Saij\WpAppFramework\Block\TemplateBlock;
use Saij\WpAppFramework\Twig\TemplateRenderer;

/**
 * Buttons in a row.
 */
#[Block('buttons', title: 'Buttons', category: Category::Content, icon: 'button', ancestor: [Section::class])]
#[Supports(contentRole: true)]
#[InnerBlocks(allowed: [Button::class], template: [new TemplateBlock(Button::class)], orientation: Orientation::Horizontal, defaultBlock: new TemplateBlock(Button::class), directInsert: true)]
final readonly class Buttons
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(ButtonsAttributes $attrs, string $content): string
    {
        return $this->renderer->render('Block/Buttons/Buttons.twig', ['attrs' => $attrs, 'content' => $content]);
    }
}
