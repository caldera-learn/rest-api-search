<?php

namespace CalderaLearn\RestSearch;

use stdClass;
use WP_Post;

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
	 * Demonstrates a different approach to setting the posts that WP_Query returns.
	 *
	 * @uses "posts_pre_query"
	 *
	 * @param array|null $postsOrNull   Return an array of post data to short-circuit WP's query,
	 *                                  or null to allow WP to run its normal queries.
	 * @return WP_Post[]
	 */
	public static function callback($postsOrNull)
	{
		// Bail out if not running during WordPress API requests.
		if (!static::shouldFilter()) {
			return $postsOrNull;
		}

		// Bail out if the posts were already sent out. Prevents recursions.
		if (!is_null($postsOrNull)) {
			return $postsOrNull;
		}

		// Get and then return the mock data.
		return static::getPosts();
	}

	/** @inheritdoc */
	public static function shouldFilter() :bool
	{
		return did_action('rest_api_init');
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
		// Create 4 mock posts with different titles.
		$mockPosts = [];
		for ($postNum = 0; $postNum <= 3; $postNum++) {
			$post = new WP_Post((new stdClass()));
			$post->post_title = "Mock Post {$postNum}";
			$post->filter = 'raw';
			$mockPosts[$postNum] = $post;
		}
		// Return a mock array of mock posts.
		return $mockPosts;
	}
}
