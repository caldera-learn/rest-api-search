<?php

namespace CalderaLearn\RestSearch\Tests\Mock;

/**
 * Class FilterWPQuery
 *
 * Mock class that is totally decoupled from WordPress
 *
 * @package CalderaLearn\RestSearch\Tests\Mock
 */
class FilterWPQuery extends \CalderaLearn\RestSearch\FilterWPQuery
{
	/** @inheritdoc */
	public static function shouldFilter($postsOrNull): bool
	{
		return is_null($postsOrNull);
	}

	/** @inheritdoc */
	public static function removeFilter(): bool
	{
		return true;
	}

	/** @inheritdoc */
	public static function getPosts(): array
	{
		//Create 4 mock posts with different titles
		$mockPosts = [];
		for ($i = 0; $i <= 3; $i++) {
			$mockPosts[$i] = (new \WP_Post((new \stdClass())));
			$mockPosts[$i]->post_title = "Mock Post $i";
		}
		//Return a mock array of mock posts
		return $mockPosts;
	}
}
