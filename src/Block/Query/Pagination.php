<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Query;

use Saij\Strata\Block\Category;
use Saij\WpAppFramework\Block\Block;
use Saij\WpAppFramework\Block\Context;
use Saij\WpAppFramework\Twig\TemplateRenderer;
use WP_Query;

/**
 * Links to the other pages of the posts of the page (archive, search, blog); nothing for the latest posts, which
 * have one page.
 */
#[Block('pagination', title: 'Pagination', category: Category::Layout, icon: 'controls-forward', parent: [Query::class])]
final readonly class Pagination
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(
        PaginationAttributes $attrs,
        #[Context(Query::class, 'source')]
        QuerySource $source = QuerySource::Page,
    ): string {
        global $wp_query;
        $links = [];
        if ($source === QuerySource::Page && !wp_is_serving_rest_request() && $wp_query instanceof WP_Query && $wp_query->max_num_pages > 1) {
            /** @var list<string>|string|null $links With type array, a list of links (null for one page). */
            $links = paginate_links([
                'type' => 'array',
                'total' => $wp_query->max_num_pages,
                'prev_text' => esc_html($attrs->previous),
                'next_text' => esc_html($attrs->next),
            ]);
        }

        return $this->renderer->render('Block/Query/Pagination.twig', [
            'attrs' => $attrs,
            'links' => is_array($links) ? $links : [],
            'sample' => wp_is_serving_rest_request(),
        ]);
    }
}
