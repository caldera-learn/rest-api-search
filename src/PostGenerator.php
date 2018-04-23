<?php

namespace CalderaLearn\RestSearch;

use stdClass;
use WP_Post;

class PostGenerator {

	/**
	 * Generates an array of mocked posts.
	 *
	 * @param int $quantity Number of posts to generate.
	 *
	 * @return array
	 */
	public static function generate( $quantity ) : array
	{
		$mockPosts = [];
		for ($i = 0; $i <= $quantity; $i++) {
			$post = new WP_Post(new stdClass());
			$post->post_title = "Mock Post $i";
			$post->filter = 'raw';
			$mockPosts[$i] = $post;
		}

		return $mockPosts;
	}
}