<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Scheme;

use WebCodingCat\WpAppFramework\Setting\SettingsGroup;
use WebCodingCat\WpAppFramework\Value\ListOf;

/**
 * The color schemes of the site: the first one colors the whole page; sections, groups and columns can choose any of
 * them (block support ColorSchemeSupport). Option strata_color_schemes.
 */
#[SettingsGroup('color_schemes', title: 'Color schemes', description: 'The first scheme colors the whole page; sections, groups and columns can choose any of them.')]
final readonly class ColorSchemes
{
    /**
     * @param list<ColorScheme> $schemes
     */
    public function __construct(
        #[ListOf(ColorScheme::class, min: 1, itemLabel: 'Color scheme')]
        public array $schemes = [
            new ColorScheme('a1e5c0de', 'Page', '#ffffff', '#16181d', '#2f5bea'),
            new ColorScheme('b2d4e6f8', 'Soft', '#f3f4f1', '#16181d', '#2f5bea'),
            new ColorScheme('c3f5a7d9', 'Dark', '#16181d', '#f3f4f1', '#8aa4ff'),
        ],
    ) {}

    /**
     * The scheme of the page.
     */
    public function page(): ColorScheme
    {
        return $this->schemes[0] ?? new ColorScheme();
    }

    /**
     * The schemes blocks can choose: all with an identifier (a scheme gets one when the group is saved).
     *
     * @return list<ColorScheme>
     */
    public function choices(): array
    {
        return array_values(array_filter($this->schemes, static fn(ColorScheme $scheme): bool => $scheme->id !== ''));
    }
}
