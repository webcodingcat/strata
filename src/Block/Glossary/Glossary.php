<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Glossary;

use Saij\Strata\Block\Category;
use Saij\Strata\Block\Section\Section;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Block\InnerBlocks;
use Saij\WpAppFramework\Block\Supports;
use Saij\WpAppFramework\Block\TemplateBlock;
use Saij\WpAppFramework\Twig\TemplateRenderer;
use WP_Block;

/**
 * A glossary: terms with their explanations, in the order the editor gives them, and an index A–Z that links every
 * letter to its first term (letters without a term are shown faint).
 */
#[Block('glossary', title: 'Glossary', category: Category::Content, icon: 'book-alt', description: 'Terms with explanations and an index A–Z.', keywords: ['lexicon', 'dictionary', 'terms'], ancestor: [Section::class])]
#[Supports(contentRole: true, anchor: true)]
#[InnerBlocks(allowed: [GlossaryTerm::class], template: [new TemplateBlock(GlossaryTerm::class)], defaultBlock: new TemplateBlock(GlossaryTerm::class), directInsert: true)]
final readonly class Glossary
{
    /** The letter of terms that start with no letter A–Z (after removing accents). */
    private const string OTHER = '#';

    public function __construct(private TemplateRenderer $renderer) {}

    public function render(GlossaryAttributes $attrs, string $content, WP_Block $block): string
    {
        return $this->renderer->render('Block/Glossary/Glossary.twig', [
            'attrs' => $attrs,
            'content' => $content,
            'letters' => $attrs->index ? $this->letters($block) : [],
        ]);
    }

    /**
     * The index: every letter A–Z (and `#` when a term starts otherwise) with the anchor of its first term, or null.
     *
     * @return list<array{letter: string, anchor: ?string}>
     */
    private function letters(WP_Block $block): array
    {
        $anchors = array_fill_keys(range('A', 'Z'), null);
        foreach (self::terms($block) as $term) {
            if (GlossaryTerm::anchor($term) !== '') {
                $anchors[self::letter($term)] ??= GlossaryTerm::anchor($term);
            }
        }

        return array_map(
            static fn(string $letter): array => ['letter' => $letter, 'anchor' => $anchors[$letter]],
            array_map('strval', array_keys($anchors)),
        );
    }

    /**
     * The terms of the inner blocks, as parsed (WordPress types the parsed block as a plain array).
     *
     * @return list<string>
     */
    private static function terms(WP_Block $block): array
    {
        $terms = [];
        $inner = $block->parsed_block['innerBlocks'] ?? [];
        foreach (is_array($inner) ? $inner : [] as $parsed) {
            $term = is_array($parsed) && is_array($parsed['attrs'] ?? null) ? $parsed['attrs']['term'] ?? '' : '';
            if (is_string($term)) {
                $terms[] = $term;
            }
        }

        return $terms;
    }

    private static function letter(string $term): string
    {
        $first = strtoupper(substr(remove_accents(ltrim($term)), 0, 1));

        return $first >= 'A' && $first <= 'Z' && strlen($first) === 1 ? $first : self::OTHER;
    }
}
