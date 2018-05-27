<?php

namespace CalderaLearn\RestSearch\ContentGetter;

use stdClass;
use WP_Post;
use WP_Query;

/**
 * Handles generating posts for the search query.
 * @package CalderaLearn\RestSearch\ContentGetter
 */
class PostsGenerator implements ContentGetterContract
{
    /**
     * Instance of the query.
     *
     * @var WP_Query
     */
    protected $query;

    /**
     * Handles getting the content for the search query.
     *
     * @param WP_Query $query Instance of the query.
     *
     * @return array
     */
    public function getContent(WP_Query $query): array
    {
        $this->query = $query;

        return $this->generatePosts($this->getQuantity());
    }

    /**
     * Gets the quantity to be generated.
     *
     * @return int
     */
    private function getQuantity(): int
    {
        if (!isset($this->query->query)) {
            return 4;
        }

        if (!isset($this->query->query['posts_per_page'])) {
            return 4;
        }

        return $this->query->query['posts_per_page'];
    }

    /**
     * Generates an array of mocked posts.
     *
     * @param int $quantity Number of posts to generate.
     *
     * @return array
     */
    private function generatePosts($quantity): array
    {
        $mockPosts = [];
        for ($postNumber = 0; $postNumber < $quantity; $postNumber++) {
            $post             = new WP_Post(new stdClass());
            $post->post_title = "Mock Post {$postNumber}";
            $post->filter     = 'raw';
            $mockPosts[]      = $post;
        }

        return $mockPosts;
    }
}
