<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Navigation;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

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
