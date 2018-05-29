<?php


namespace CalderaLearn\RestSearch;

use CalderaLearn\RestSearch\ContentGetter\ContentGetterContract;
use CalderaLearn\RestSearch\ContentGetter\PostsGenerator;

class Modes
{

	/**
	 * Controls loading of content generator based on mode
	 *
	 * @param \WP_Query $unused
	 * @param \WP_REST_Request $request
	 * @return ContentGetterContract
	 */
	public function controlMode($unused, \WP_REST_Request $request) : ContentGetterContract
	{
		switch ($request->get_param('mode')) {
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
