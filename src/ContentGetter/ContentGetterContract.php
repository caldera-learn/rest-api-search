<?php

namespace CalderaLearn\RestSearch\ContentGetter;

use WP_Query;

/**
 * Defines the contract for each content getter implementation.
 * @package CalderaLearn\RestSearch\ContentGetter
 */
interface ContentGetterContract
{
	/**
	 * Handles getting the content for the search query.
	 *
	 * @param WP_Query $query Instance of the query.
     * @param \WP_REST_Request $request
     *
     * @return array
     */
	public function getContent(WP_Query $query,\WP_REST_Request $request ): array;
}
