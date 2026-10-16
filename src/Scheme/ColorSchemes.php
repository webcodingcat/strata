<?php

declare(strict_types=1);

namespace Saij\Strata\Scheme;

use Saij\WpAppFramework\Setting\SettingsGroup;
use Saij\WpAppFramework\Value\ListOf;

/**
 * The color schemes of the site: the first one colors the whole page, the others can be chosen for sections and
 * groups (block support ColorSchemeSupport). Option strata_color_schemes.
 */
#[SettingsGroup('color_schemes', title: 'Color schemes', description: 'The first scheme colors the whole page; sections and groups can use the others.')]
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
     * The schemes sections and groups can choose: all but the first.
     *
     * @return list<ColorScheme>
     */
    public function choices(): array
    {
        return array_values(array_filter(
            array_slice($this->schemes, 1),
            static fn(ColorScheme $scheme): bool => $scheme->id !== '',
        ));
    }
}
