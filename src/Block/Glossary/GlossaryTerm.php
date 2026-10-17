<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Glossary;

use Saij\Strata\Block\Category;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Twig\TemplateRenderer;

/**
 * A term of the glossary with its explanation; the explanation is stored in the post content, so search and exports
 * find it. The term is an anchor of its own (`#coaster-step`), which the index of the glossary links to.
 */
#[Block('glossary-term', title: 'Glossary term', category: Category::Content, icon: 'editor-textcolor', parent: [Glossary::class])]
final readonly class GlossaryTerm
{
    public function __construct(private TemplateRenderer $renderer) {}

    /** The anchor of a term: its slug. */
    public static function anchor(string $term): string
    {
        return sanitize_title($term);
    }

    public function render(GlossaryTermAttributes $attrs): string
    {
        return $this->renderer->render('Block/Glossary/GlossaryTerm.twig', [
            'attrs' => $attrs,
            'anchor' => self::anchor($attrs->term),
        ]);
    }
}
