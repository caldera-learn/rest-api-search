<?php

namespace CalderaLearn\RestSearch;

use CalderaLearn\RestSearch\ContentGetter\ContentGetterContract;

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
	 * Content Getter Implementation.
	 *
	 * @var ContentGetterContract
	 */
	protected static $contentGetter;

	/**
	 * Priority for filter
	 *
	 * @var int
	 */
	protected static $filterPriority = 10;

	/**
	 * Initialize the search filter by binding a specific content getter implementation.
	 *
	 * @param ContentGetterContract $contentGetter Instance of the implementation.
	 *
	 * @return void
	 */
	public static function init(ContentGetterContract $contentGetter)
	{
		static::$contentGetter = $contentGetter;
	}

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
		return static::$contentGetter->getContent();
	}
}
