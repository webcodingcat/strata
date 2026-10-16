<?php

declare(strict_types=1);

namespace Saij\Strata\Editor;

use Saij\WpAppFramework\Block\CoreBlock;
use Saij\WpAppFramework\Hook\Hook;
use WP_Block_Type_Registry;

/**
 * The blocks editors can insert: the blocks of the theme and of plugins, and of the core blocks only those that store
 * no markup in the post content and fit the theme (PLAN.md, Blocks). The theme replaces the others with blocks of its
 * own.
 */
final class AllowedBlocks
{
    /** Core blocks that store nothing in the post content and that the theme styles. */
    private const array CORE = [
        CoreBlock::Block,
        CoreBlock::Pattern,
        CoreBlock::PostContent,
        CoreBlock::PostDate,
        CoreBlock::PostExcerpt,
        CoreBlock::PostFeaturedImage,
        CoreBlock::PostAuthorName,
        CoreBlock::PostTerms,
        CoreBlock::PostTitle,
        CoreBlock::QueryTitle,
        CoreBlock::ReadMore,
        CoreBlock::Search,
        CoreBlock::SiteLogo,
        CoreBlock::SiteTagline,
        CoreBlock::SiteTitle,
        CoreBlock::TemplatePart,
    ];

    /**
     * @param bool|list<string> $allowed What WordPress or other code allows: true for all blocks.
     * @return list<string>
     */
    #[Hook('allowed_block_types_all')]
    public function filter(bool|array $allowed): array
    {
        $names = $allowed === true
            ? array_keys(WP_Block_Type_Registry::get_instance()->get_all_registered())
            : ($allowed === false ? [] : $allowed);
        $core = array_map(static fn(CoreBlock $block): string => $block->value, self::CORE);

        return array_values(array_filter(
            $names,
            static fn(string $name): bool => !str_starts_with($name, 'core/') || in_array($name, $core, true),
        ));
    }
}
