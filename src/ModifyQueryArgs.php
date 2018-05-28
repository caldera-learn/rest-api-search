<?php


namespace CalderaLearn\RestSearch;

/**
 * Class ModifyQuery
 *
 * Modify WP_Query Args
 *
 * @package ExamplePlugin
 */
class ModifyQueryArgs extends FilterQueryArgs
{



	/** @inheritdoc */
	public function getAdditionalQueryArguments() :array
	{
		return [
			'post_type' => $this->restBasesToPostTypeSlugs($this->getRequest()[ModifySchema::ARGNAME])
		];
	}

	/** @inheritdoc */
	public function filterQueryArgs($args, $request)
	{
		if ($this->shouldFilter($args['post_type'])) {
			$this->setRequest($request);
			add_filter('posts_pre_query', [FilterWPQuery::class, 'posts_pre_query'], 10, 2);
			$args = array_merge($this->getAdditionalQueryArguments(), $args);
		}
		return $args;
	}

	/** @inheritdoc */
	public function shouldFilter(string $postTypeSlug): bool
	{
		return 'post' === $postTypeSlug;
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
