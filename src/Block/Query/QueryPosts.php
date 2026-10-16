<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Query;

use WP_Post;
use WP_Query;

/**
 * The posts of a query block: those of the main query of the page, or the latest published posts. Renders for the
 * block editor go through the REST API, whose main query lists no posts; there the latest posts stand in, so the
 * post template has items to design.
 */
final class QueryPosts
{
    /**
     * @return list<WP_Post>
     */
    public function posts(QuerySource $source, int $count): array
    {
        if ($source === QuerySource::Page && !wp_is_serving_rest_request()) {
            global $wp_query;

            return $wp_query instanceof WP_Query ? self::only($wp_query->posts) : [];
        }

        $query = new WP_Query([
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => max(1, $count),
            'ignore_sticky_posts' => true,
            'no_found_rows' => true,
        ]);

        return self::only($query->posts);
    }

    /**
     * @param array<int|WP_Post>|null $posts
     * @return list<WP_Post>
     */
    private static function only(?array $posts): array
    {
        return array_values(array_filter($posts ?? [], static fn(int|WP_Post $post): bool => $post instanceof WP_Post));
    }
}
