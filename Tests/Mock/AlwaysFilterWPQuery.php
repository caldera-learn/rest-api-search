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
        for ($postNumber = 0; $postNumber < 2; $postNumber++) {
            $id      = wp_insert_post([
                'post_title'   => "This is a mocked post for {$postNumber}.",
                'post_content' => 'This is some amazing test content.',
            ]);
            $posts[] = get_post($id);
        }

        return $posts;
    }
}
