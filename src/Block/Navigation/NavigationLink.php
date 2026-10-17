<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Navigation;

use Saij\Strata\Block\Category;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Twig\TemplateRenderer;

/**
 * A link of the navigation: to a section of the page (a free URL such as `#training`, or `/#training` from other
 * pages) or to a page.
 */
#[Block('navigation-link', title: 'Navigation link', category: Category::Content, icon: 'admin-links', parent: [Navigation::class])]
final readonly class NavigationLink
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(NavigationLinkAttributes $attrs): string
    {
        return $this->renderer->render('Block/Navigation/NavigationLink.twig', ['attrs' => $attrs]);
    }
}
