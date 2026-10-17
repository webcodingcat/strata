<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\People;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Block\Section\Section;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Block\InnerBlocks;
use WebCodingCat\WpAppFramework\Block\Orientation;
use WebCodingCat\WpAppFramework\Block\Supports;
use WebCodingCat\WpAppFramework\Block\TemplateBlock;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * A grid of people – a team, a board, contact persons – each with photo, name, role and optional phone and email.
 */
#[Block('people', title: 'People', category: Category::Content, icon: 'groups', description: 'A grid of people with photo, name and role.', keywords: ['team', 'board', 'contact'], ancestor: [Section::class])]
#[Supports(contentRole: true)]
#[InnerBlocks(allowed: [Person::class], template: [new TemplateBlock(Person::class)], orientation: Orientation::Horizontal, defaultBlock: new TemplateBlock(Person::class), directInsert: true)]
final readonly class People
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(PeopleAttributes $attrs, string $content): string
    {
        return $this->renderer->render('Block/People/People.twig', ['attrs' => $attrs, 'content' => $content]);
    }
}
