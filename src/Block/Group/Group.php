<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Group;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Block\Section\Section;
use WebCodingCat\Strata\Scheme\ColorSchemeSupport;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Block\Support\UseSupport;
use WebCodingCat\WpAppFramework\Block\Supports;
use WebCodingCat\WpAppFramework\Block\Variation;
use WebCodingCat\WpAppFramework\Block\VariationScope;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * Blocks one below the other or in a row; with a color scheme it becomes a box.
 */
#[Block('group', title: 'Group', category: Category::Layout, icon: 'group', description: 'Blocks one below the other or in a row.', ancestor: [Section::class])]
#[Supports(contentRole: true, anchor: true)]
#[UseSupport(ColorSchemeSupport::class)]
#[Variation('stack', 'Stack', icon: 'arrow-down-alt', attributes: ['layout' => GroupLayout::Stack], scope: [VariationScope::Inserter, VariationScope::Transform], isDefault: true, isActive: ['layout'])]
#[Variation('row', 'Row', icon: 'arrow-right-alt', attributes: ['layout' => GroupLayout::Row], scope: [VariationScope::Inserter, VariationScope::Transform], isActive: ['layout'])]
final readonly class Group
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(GroupAttributes $attrs, string $content): string
    {
        return $this->renderer->render('Block/Group/Group.twig', ['attrs' => $attrs, 'content' => $content]);
    }
}
