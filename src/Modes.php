<?php


namespace CalderaLearn\RestSearch;

use CalderaLearn\RestSearch\ContentGetter\ContentGetterContract;
use CalderaLearn\RestSearch\ContentGetter\PostsGenerator;

/**
 * Class Modes
 *
 * Controls which ContentGetter is used based on a REST API param "mode"
 */
class Modes
{

	/**
	 * The name of the filter this class uses to control search mode
	 */
	const FILTER_NAME = 'caldera_learn_rest_search_get_mode';

	/**
	 * Controls loading of content generator based on mode
	 *
	 * @param \WP_Query $unused
	 * @param \WP_REST_Request $request
	 * @return ContentGetterContract
	 */
	public function controlMode($unused, \WP_REST_Request $request) : ContentGetterContract
	{
		$mode = $request->get_param('mode');
		$contentGetter = apply_filters(self::FILTER_NAME, null, $mode);
		if (is_a($contentGetter, ContentGetterContract::class)) {
			return $contentGetter;
		}
		switch ($mode) {
			default:
				return $this->factory('');
			break;
		}
	}


	/**
	 * Factory for contentGetter with cache
	 *
	 * @todo cache
	 *
	 * @param string $type
	 * @return ContentGetterContract
	 */
	public function factory(string $type) : ContentGetterContract
	{
		switch ($type) {
			case PostsGenerator::class:
			default:
				return new PostsGenerator();
		}
	}
}
