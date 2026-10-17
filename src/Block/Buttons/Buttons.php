<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Buttons;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Block\Section\Section;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Block\InnerBlocks;
use WebCodingCat\WpAppFramework\Block\Orientation;
use WebCodingCat\WpAppFramework\Block\Supports;
use WebCodingCat\WpAppFramework\Block\TemplateBlock;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

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
