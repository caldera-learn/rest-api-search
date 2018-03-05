<?php

namespace CalderaLearn\RestSearch;

/**
 * Class FilterWPQuery
 *
 * Changes WP_Query object
 *
 * @package ExamplePlugin
 */
class FilterWPQuery
{
	// phpcs:disable
	/**
	 * Demonstrates how to use a different way to set the posts that WP_Query returns
	 *
	 * @uses "posts_pre_query"
	 *
	 * @param $postsOrNull
	 * @return \WP_Post[]
	 */
	public static function callback($postsOrNull)
	{
		// phpcs:enable
		//Only run during WordPress API requests
		if (static::shouldFilter()) {
			//Prevent recursions
			//Don't run if posts are already sent
			if (is_null($postsOrNull)) {
				//Get mock data
				$postsOrNull = static ::getPosts();
			}
			//Always return something, even if its unchanged
			return $postsOrNull;
		}
	}

	/** @inheritdoc */
	public static function shouldFilter() :bool
	{
		return defined('REST_REQUEST') && REST_REQUEST;
	}

	/** @inheritdoc */
	public static function removeFilter()
	{
		remove_filter('posts_pre_query', [FilterWPQuery::class, 'posts_pre_query'], 10);
	}

	/** @inheritdoc */
	public static function getPosts() : array
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
