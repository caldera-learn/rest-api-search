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
	 * Filters the results of WP_Query objects.
	 *
	 * This callback demonstrates how to use a different way to set the posts that WP_Query returns.
	 *
	 * @uses "posts_pre_query"
	 *
	 * @param $postsOrNull
	 *
	 * @return array Returns an array of WP_Post objects.
	 */
	public static function filterPreQuery($postsOrNull)
	{
		if ( ! static::shouldFilter($postsOrNull)) {
			return $postsOrNull;
		}

		return static::getPosts();
	}

	/** @inheritdoc */
	public static function shouldFilter($postsOrNull): bool
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
	private static function doingREST(): bool
	{
		return did_action('rest_api_init');
	}

	/** @inheritdoc */
	public static function addFilter(): bool
	{
		return add_filter('posts_pre_query', [FilterWPQuery::class, 'filterPreQuery'], static::$filterPriority);
	}

	/** @inheritdoc */
	public static function removeFilter(): bool
	{
		return remove_filter('posts_pre_query', [FilterWPQuery::class, 'filterPreQuery'], static::$filterPriority);
	}

	/** @inheritdoc */
	public static function getFilterPriority(): int
	{
		return static::$filterPriority;
	}

	/** @inheritdoc */
	public static function getPosts(): array
	{
		return static::generatePosts(4);
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
