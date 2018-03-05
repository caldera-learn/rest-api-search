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
	 * Change the results of WP_Query objects
	 *
	 * @uses "posts_pre_query"
	 *
	 * @param $postsOrNull
	 * @param \WP_Query $query
	 * @return \WP_Post[]
	 */
	public static function callback($postsOrNull, $query);

	/**
	 * Should this request be filtered?
	 *
	 * @return bool
	 */
	public static function shouldFilter() :bool;

	/**
	 * Remove the filter using this callback
	 *
	 * @return void
	 */
	public static function removeFilter();

	/**
	 * Create the array of posts to return
	 *
	 * @return \WP_Post[]
	 */
	public static function getPosts() :array;
}
