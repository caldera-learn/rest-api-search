<?php


namespace CalderaLearn\RestSearch;

use WP_Post;

/**
 * Interface FiltersPreWPQuery
 *
 * Interface that classes filtering WPQuery at the posts_pre_query filter should use
 *
 * @package CalderaLearn\RestSearch
 */
interface FiltersPreWPQuery
{
	/**
	 * Change the results of WP_Query objects
	 *
	 * @uses "posts_pre_query"
	 *
	 * @param array|null $postsOrNull   Return an array of post data to short-circuit WP's query,
	 *                                  or null to allow WP to run its normal queries.
	 * @return WP_Post[]
	 */
	public static function callback($postsOrNull);

	/**
	 * Should this request be filtered?
	 *
	 * @return bool
	 */
	public static function shouldFilter() :bool;

	/**
	 * Remove the filter using this callback
	 *
	 * @return bool
	 */
	public static function removeFilter() :bool;

	/**
	 * Add the filter, using this callback
	 *
	 * @return bool
	 */
	public static function addFilter() : bool;

	/**
	 * Get the priority for the filter
	 *
	 * @return int
	 */
	public static function getFilterPriority() : int;

	/**
	 * Create the array of posts to return
	 *
	 * @return WP_Post[]
	 */
	public static function getPosts() :array;
}
