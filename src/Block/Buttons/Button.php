<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Buttons;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * A link that looks like a button: primary (accent), secondary (outlined) or text.
 */
#[Block('button', title: 'Button', category: Category::Content, icon: 'button', parent: [Buttons::class])]
final readonly class Button
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(ButtonAttributes $attrs): string
    {
        return $this->renderer->render('Block/Buttons/Button.twig', ['attrs' => $attrs]);
    }
}
