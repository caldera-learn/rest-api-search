<?php


namespace CalderaLearn\RestSearch;

/**
 * Class ModifyQuery
 *
 * Modify WP_Query Args
 *
 * @package ExamplePlugin
 */
class ModifyQueryArgs implements ModifyQueryArgsContract
{
	use UsesPreparedPostTypes;
	/**
	 * @var \WP_REST_Request
	 */
	protected $request;

	/** @inheritdoc */
	public function getAdditionalQueryArguments() :array
	{
		return [
			'post_type' => $this->restBasesToPostTypeSlugs($this->request[ModifySchema::ARGNAME])
		];
	}

    /** @inheritdoc */
    public function filterQueryArgs($args, $request)
	{
		if ($this->shouldFilter($request)) {
			$this->request = $request;
			add_filter('posts_pre_query', [FilterWPQuery::class, 'posts_pre_query'], 10, 2);
			$args = array_merge($this->getAdditionalQueryArguments(), $args);
		}
		return $args;
	}

    /** @inheritdoc */
    public function shouldFilter(\WP_REST_Request $request): bool
	{
		$attributes = $request->get_attributes();
		if (isset($attributes['args'][ModifySchema::ARGNAME])) {
			if ($request->get_param(ModifySchema::ARGNAME)) {
				return true;
			}
		}

		return false;
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
			if ($this->preparedPostTypes->restBaseToSlug($postTypeRestBase)) {
				$postTypeSlugs[] = $this->preparedPostTypes->restBaseToSlug($postTypeRestBase);
			}
		}

		return $postTypeSlugs;
	}
}
