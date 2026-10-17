<?php

declare(strict_types=1);

namespace Saij\Strata\Scheme;

use Saij\WpAppFramework\Block\Support\BlockSupport;

/**
 * The color scheme of a section, group or column: the identifier of one of the schemes. Without one, or if the
 * scheme no longer exists, the block keeps the scheme around it.
 */
#[BlockSupport('colorScheme', label: 'Color scheme')]
final readonly class ColorSchemeSupport
{
    public function __construct(private ColorSchemes $schemes) {}

    public function className(string $value = ''): ?string
    {
        foreach ($this->schemes->choices() as $scheme) {
            if ($scheme->id === $value) {
                return 'has-scheme ' . SchemeStyles::className($scheme);
            }
        }

        return null;
    }
}
