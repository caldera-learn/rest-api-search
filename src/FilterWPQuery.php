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
	 * @param array|null $postsOrNull Array of posts.
	 * @return array Returns an array of WP_Post objects.
	 */
	public static function callback($postsOrNull)
	{
		if ( ! static::shouldFilter($postsOrNull)) {
			return $postsOrNull;
		}

		//Get mock data
		$postsOrNull = static::getPosts();

		//Always return something, even if its unchanged
		return $postsOrNull;
	}

	/** @inheritdoc */
	public static function shouldFilter($postsOrNull) :bool
	{
		if ( ! is_null($postsOrNull)) {
			return false;
		}

		return static::doingREST();
	}

	/**
	 * Checks if WordPress is doing a REST request.
	 *
	 * @return bool
	 */
	private static function doingREST() :bool
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
		return PostGenerator::generate(4);
	}
}
