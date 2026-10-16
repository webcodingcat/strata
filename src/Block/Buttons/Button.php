<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Buttons;

use Saij\Strata\Block\Category;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Twig\TemplateRenderer;

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
