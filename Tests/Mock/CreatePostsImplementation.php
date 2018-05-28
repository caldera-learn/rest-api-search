<?php

namespace CalderaLearn\RestSearch\Tests\Mock;

use CalderaLearn\RestSearch\ContentGetter\ContentGetterContract;
use WP_Query;

/**
 * Class FilterWPQuery
 *
 * Mock class that is totally decoupled from WordPress
 *
 * @package CalderaLearn\RestSearch\Tests\Mock
 */
class CreatePostsImplementation implements ContentGetterContract
{
	/** @inheritdoc */
	public function getContent(WP_Query $query, \WP_REST_Request $request): array
	{
		$quantity = $query->query['posts_per_page'];
		$posts    = [];

		for ($index = 0; $index < $quantity; $index++) {
			$postId  = wp_insert_post([
				'post_title'   => "This is an inserted post for {$index}.",
				'post_content' => 'This is some really awesome content about testing.',
			]);
			$posts[] = get_post($postId);
		}

		return $posts;
	}
}
