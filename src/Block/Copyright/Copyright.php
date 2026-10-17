<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Copyright;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\Strata\Block\Section\Section;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * "© 2026 Holder": the year is always the current one, from an optional first year ("© 2019–2026"); the holder is
 * edited in the canvas, the site title without one.
 */
#[Block('copyright', title: 'Copyright', category: Category::Content, icon: 'privacy', description: 'The copyright line with the current year.', ancestor: [Section::class])]
final readonly class Copyright
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(CopyrightAttributes $attrs): string
    {
        $year = (int) wp_date('Y');
        $since = $attrs->since !== null && $attrs->since < $year ? $attrs->since . '–' : '';

        return $this->renderer->render('Block/Copyright/Copyright.twig', ['attrs' => $attrs, 'years' => $since . $year]);
    }
}
