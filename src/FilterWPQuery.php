<?php

namespace CalderaLearn\RestSearch;

/**
 * Class FilterWPQuery
 *
 * Changes WP_Query object during REST API requests
 *
 * @package CalderaLearn\RestSearch
 */
class FilterWPQuery implements FiltersPreWPQuery
{

	/**
	 * Priority for filter
	 *
	 * @var int
	 */
	protected static $filterPriority = 10;
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
		if ( ! static::shouldFilter($postsOrNull)) {
			return $postsOrNull;
		}

		// Get mock data
		$postsOrNull = static::getPosts();

		return $postsOrNull;
	}

	/** @inheritdoc */
	public static function shouldFilter($postsOrNull) :bool
	{
		// Null checker.
		if ( ! is_null($postsOrNull)) {
			return false;
		}

		// REST request checker.
		if ( ! did_action('rest_api_init')) {
			return false;
		}

		return true;
	}

	/** @inheritdoc */
	public static function addFilter() : bool
	{
		return add_filter('posts_pre_query', [FilterWPQuery::class, 'callback'], 10);
	}

	/** @inheritdoc */
	public static function removeFilter() : bool
	{
		return remove_filter('posts_pre_query', [FilterWPQuery::class, 'callback'], 10);
	}

	/** @inheritdoc */
	public static function getFilterPriority() : int
	{
		return static::$filterPriority;
	}


	/** @inheritdoc */
	public static function getPosts() : array
	{
		//Create 4 mock posts with different titles
		$mockPosts = [];
		for ($i = 0; $i <= 3; $i++) {
			$post = new \WP_Post((new \stdClass()));
			$post->post_title = "Mock Post $i";
			$post->filter = 'raw';
			$mockPosts[$i] = $post;
		}
		//Return a mock array of mock posts
		return $mockPosts;
	}
}
