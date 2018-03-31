<?php


namespace CalderaLearn\RestSearch;

/**
 * Class ModifyQuery
 *
 * Modify WP_Query Args
 *
 * @package ExamplePlugin
 */
class ModifyQueryArgs
{
	use UsesPreparedPostTypes;


	/**
	 * Filter query args if needed
	 *
	 * @param array $args Key value array of query var to query value.
	 * @param \WP_REST_Request $request The request used.
	 *
	 * @return array
	 */
	public function filterQueryArgs($args, $request)
	{
		if (!$this->shouldFilter($request)) {
			return $args;
		}

		add_filter('posts_pre_query', [FilterWPQuery::class, 'posts_pre_query'], 10, 2);
		$args['post_type'] = $this->restBasesToPostTypeSlugs($request[ModifySchema::ARGNAME]);

		return $args;
	}

	/**
	 * Check if we should filter request args
	 *
	 * @param \WP_REST_Request $request
	 * @return bool
	 */
	public function shouldFilter(\WP_REST_Request $request): bool
	{
		$attributes = $request->get_attributes();
		if (!isset($attributes['args'][ModifySchema::ARGNAME])) {
			return false;
		}

		return $request->get_param(ModifySchema::ARGNAME);
	}

	/**
	 * Convert an array of rest bases to post type slugs
	 *
	 * @param array $postTypes
	 * @return array
	 */
	public function restBasesToPostTypeSlugs(array $postTypes): array
	{
		$postTypeSlugs = [];
		foreach ($postTypes as $postTypeRestBase) {
			$newSlug = $this->preparedPostTypes->restBaseToSlug($postTypeRestBase);
			if (!empty($newSlug)) {
				$postTypeSlugs[] = $newSlug;
			}
		}

		return $postTypeSlugs;
	}
}
