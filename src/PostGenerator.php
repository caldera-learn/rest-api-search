<?php

namespace CalderaLearn\RestSearch;

use stdClass;
use WP_Post;

class PostGenerator
{
	/**
	 * Generates an array of mocked posts.
	 *
	 * @param int $quantity Number of posts to generate.
	 *
	 * @return array
	 */
	public static function generate($quantity) : array {
		$mockPosts = [];
		for ($postNumber = 0; $postNumber <= $quantity; $postNumber++) {
			$post                     = new WP_Post( new stdClass() );
			$post->post_title         = "Mock Post {$postNumber}";
			$post->filter             = 'raw';
			$mockPosts[ $postNumber ] = $post;
		}

		return $mockPosts;
	}
}