<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Navigation;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Block\Section\Section;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Block\InnerBlocks;
use WebCodingCat\WpAppFramework\Block\Orientation;
use WebCodingCat\WpAppFramework\Block\Supports;
use WebCodingCat\WpAppFramework\Block\TemplateBlock;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * Links to the sections of the page and to other pages: a row from `md` on; below, a menu button opens them in a
 * panel over the page (a popover, which the browser opens and closes without script; the view script closes it when
 * a link in it is followed, since a link to a section of the same page does not leave the page).
 */
#[Block('navigation', title: 'Navigation', category: Category::Content, icon: 'menu', description: 'Links to the sections of the page and to other pages, behind a menu button on small screens.', ancestor: [Section::class])]
#[Supports(contentRole: true)]
#[InnerBlocks(allowed: [NavigationLink::class], template: [new TemplateBlock(NavigationLink::class)], orientation: Orientation::Horizontal, defaultBlock: new TemplateBlock(NavigationLink::class), directInsert: true)]
final readonly class Navigation
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(NavigationAttributes $attrs, string $content): string
    {
        return $this->renderer->render('Block/Navigation/Navigation.twig', [
            'attrs' => $attrs,
            'content' => $content,
            'panelId' => wp_unique_id('strata-navigation-'),
        ]);
    }
}
