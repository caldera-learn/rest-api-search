<?php


namespace CalderaLearn\RestSearch;

/**
 * Class ModifySchema
 *
 * Modifies the REST API route schema so it has an argument "post_type"

 */
class ModifySchema extends FilterSchema
{
	use UsesPreparedPostTypes;

	/**
	 * The name of the extra argument we are adding to post type routes
	 */
	const ARGNAME = 'post_type';


	/* @inheritdoc */
	public function getAdditionalSchemaArguments(): array
	{
		return [
			self::ARGNAME => [
				[
					'default' => PostType::RESTBASE,
					'description' => __('Post type(s) for search query'),
					'type' => 'array',
					//Limit to public post types and allow query by rest base
					'items' =>
						[
							'enum' => $this->preparedPostTypes->getPostTypeRestBases(),
							'type' => 'string',
						],
				]
			]
		];
	}



	/* @inheritdoc */
	public function shouldFilter(string $postTypeSlug): bool
	{
		return PostType::SLUG === $postTypeSlug;
	}
}
