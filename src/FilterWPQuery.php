<?php

namespace CalderaLearn\RestSearch;

use CalderaLearn\RestSearch\ContentGetter\ContentGetterContract;
use WP_Query;

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
     * Current REST request
     *
     * @var \WP_REST_Request
     */
	protected static $request;

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
	 * @param array|null $postsOrNull Array of posts or null.
	 * @param WP_Query $query Instance of the query.
	 *
	 * @return array Returns an array of WP_Post objects.
	 */
	public static function filterPreQuery($postsOrNull, WP_Query $query)
	{
		if (! static::shouldFilter($postsOrNull)) {
			return $postsOrNull;
		}

		return static::getPosts($query);
	}

	/** @inheritdoc */
	public static function shouldFilter($postsOrNull): bool
	{
		if (! is_null($postsOrNull)) {
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
        add_filter( 'rest_pre_serve_request', [FilterWPQuery::class, 'captureRequest' ] );
		return add_filter('posts_pre_query', [FilterWPQuery::class, 'filterPreQuery'], static::$filterPriority, 2);
	}

	/** @inheritdoc */
	public static function removeFilter(): bool
	{
        remove_filter( 'rest_pre_serve_request', [FilterWPQuery::class, 'captureRequest' ] );
        return remove_filter('posts_pre_query', [FilterWPQuery::class, 'filterPreQuery'], static::$filterPriority);
	}

	/** @inheritdoc */
	public static function getFilterPriority(): int
	{
		return static::$filterPriority;
	}

	public static function captureRequest( $return, $result, $request )
    {
        static::$request = $request;
        return $return;
    }

	/** @inheritdoc */
	public static function getPosts(WP_Query $query): array
	{

	    $request = is_object( static::$request ) ? static::$request ? new \WP_REST_Request();
		return static::$contentGetter->getContent($query,$request);
	}
}
