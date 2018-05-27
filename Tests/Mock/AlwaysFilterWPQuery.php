<?php

namespace CalderaLearn\RestSearch\Tests\Mock;

class AlwaysFilterWPQuery extends \CalderaLearn\RestSearch\FilterWPQuery
{
    /** @inheritdoc */
    public static function shouldFilter($postsOrNull): bool
    {
        return is_null($postsOrNull);
    }

    /** @inheritdoc */
    public static function getPosts(\WP_Query $query): array
    {
        if (!function_exists('wp_insert_post')) {
            return parent::getPosts($query);
        }

        $posts   = [];
        $id      = wp_insert_post([
            'post_title'   => rand(),
            'post_content' => rand(),
        ]);
        $posts[] = get_post($id);
        $id      = wp_insert_post([
            'post_title' => rand(),
            'post_content' => rand()
        ]);
        $posts[] = get_post($id);

        return $posts;
    }
}
