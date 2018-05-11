<?php

namespace CalderaLearn\RestSearch\ContentGetter;

/**
 * Handles generating posts for the search query.
 * @package CalderaLearn\RestSearch\ContentGetter
 */
class PostsGenerator implements ContentGetterContract
{
	/**
	 * Handles getting the content for the search query.
	 *
	 * @param int $quantity Number to get.
	 *
	 * @return array
	 */
	public function getContent($quantity = 4): array
	{
		return $this->generatePosts($quantity);
	}

	/**
	 * Generates an array of mocked posts.
	 *
	 * @param int $quantity Number of posts to generate.
	 *
	 * @return array
	 */
	private static function generatePosts($quantity): array
	{
		$mockPosts = [];
		for ($postNumber = 0; $postNumber < $quantity; $postNumber++) {
			$post             = new WP_Post( new stdClass() );
			$post->post_title = "Mock Post {$postNumber}";
			$post->filter     = 'raw';
			$mockPosts[]      = $post;
		}

		return $mockPosts;
	}
}
