<?php

namespace CalderaLearn\RestSearch;

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
	 * Filters the results of WP_Query objects.
	 *
	 * @uses "posts_pre_query"
	 *
	 * @param array|null $postsOrNull Array of posts.
	 * @return array Returns an array of WP_Post objects.
	 */
	public static function filterPreQuery($postsOrNull);

	/**
	 * Checks if the request should be filtered or not.
	 *
	 * @param array|null $postsOrNull Array of WP_Posts or null.
	 * @return bool
	 */
	public static function shouldFilter($postsOrNull) : bool;

	/**
	 * Remove the filter.
	 *
	 * @return bool
	 */
	public static function removeFilter() : bool;

	/**
	 * Add the filter.
	 *
	 * @return bool
	 */
	public static function addFilter() : bool;

	/**
	 * Get the priority level for the filter.
	 *
	 * @return int
	 */
	public static function getFilterPriority() : int;

	/**
	 * Get the posts.
	 *
	 * @return array Returns an array of WP_Post objects.
	 */
	public static function getPosts() : array;
}
