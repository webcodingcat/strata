<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Facts;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * A fact: an optional icon, a label ("Training") and the value ("Tuesdays from 7 pm"), the value linked when a link
 * is given.
 */
#[Block('fact', title: 'Fact', category: Category::Content, icon: 'info-outline', parent: [Facts::class])]
final readonly class Fact
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(FactAttributes $attrs): string
    {
        return $this->renderer->render('Block/Facts/Fact.twig', ['attrs' => $attrs]);
    }
}
