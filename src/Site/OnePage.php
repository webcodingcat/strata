<?php

declare(strict_types=1);

namespace Saij\Strata\Site;

use Saij\WpAppFramework\Hook\Hook;
use WP_Query;

/**
 * A one-page site has pages, no blog: the post type "post" with its categories and tags is hidden in the backend and
 * on the front end, and the search of the front end answers with the 404 page. Posts that exist stay in the
 * database; another theme shows them again.
 */
final class OnePage
{
    /** The blog: posts and their taxonomies. */
    private const string POST_TYPE = 'post';

    private const array TAXONOMIES = ['category', 'post_tag'];

    /** What hides a post type or taxonomy everywhere: no pages, no archives, no backend, no REST API. */
    private const array HIDDEN = [
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => false,
        'show_in_menu' => false,
        'show_in_nav_menus' => false,
        'show_in_rest' => false,
    ];

    /**
     * @param array<string, mixed> $args
     * @return array<string, mixed>
     */
    #[Hook('register_post_type_args')]
    public function hidePosts(array $args, string $postType): array
    {
        return $postType === self::POST_TYPE
            ? [...$args, ...self::HIDDEN, 'show_in_admin_bar' => false, 'exclude_from_search' => true, 'has_archive' => false]
            : $args;
    }

    /**
     * @param array<string, mixed> $args
     * @return array<string, mixed>
     */
    #[Hook('register_taxonomy_args')]
    public function hideTaxonomies(array $args, string $taxonomy): array
    {
        return in_array($taxonomy, self::TAXONOMIES, true) ? [...$args, ...self::HIDDEN] : $args;
    }

    /**
     * The search of the front end: the 404 page with status 404, since a one-page site has nothing to search.
     * WordPress sets the status only for queries that are no 404 yet (WP::handle_404(), class-wp.php), so this
     * short-circuits it.
     */
    #[Hook('pre_handle_404')]
    public function noSearch(bool $preempt, WP_Query $query): bool
    {
        if ($preempt || is_admin() || !$query->is_main_query() || !$query->is_search()) {
            return $preempt;
        }
        $query->set_404();
        status_header(404);
        nocache_headers();

        return true;
    }

    /**
     * The quick draft of the dashboard writes posts.
     */
    #[Hook('wp_dashboard_setup')]
    public function noQuickDraft(): void
    {
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    }
}
