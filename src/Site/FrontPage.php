<?php

declare(strict_types=1);

namespace Saij\Strata\Site;

use Saij\WpAppFramework\Lifecycle\OnActivation;
use WP_Post;

/**
 * A one-page site shows a page as its front page: when the site switches to the theme and has no static front page
 * yet, the first published page becomes it – or, without one, a new page "Home" with a section. A front page that is
 * set already stays as it is.
 */
final class FrontPage
{
    /** The content of a new front page: one section with a heading. */
    private const string CONTENT = "<!-- wp:strata/section -->\n<!-- wp:strata/heading {\"level\":1} -->\nWelcome\n<!-- /wp:strata/heading -->\n<!-- /wp:strata/section -->";

    #[OnActivation]
    public function ensure(): void
    {
        $current = get_option('page_on_front');
        $page = is_numeric($current) ? get_post((int) $current) : null;
        if (get_option('show_on_front') === 'page' && $page instanceof WP_Post && $page->post_type === 'page' && $page->post_status === 'publish') {
            return;
        }

        $pages = get_posts(['post_type' => 'page', 'post_status' => 'publish', 'numberposts' => 1, 'orderby' => ['menu_order' => 'ASC', 'date' => 'ASC'], 'fields' => 'ids']);
        $id = is_int($pages[0] ?? null) ? $pages[0] : wp_insert_post(['post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Home', 'post_content' => self::CONTENT]);
        if ($id === 0) {
            return;
        }

        update_option('show_on_front', 'page');
        update_option('page_on_front', $id);
        // No blog: no page of posts.
        update_option('page_for_posts', 0);
    }
}
