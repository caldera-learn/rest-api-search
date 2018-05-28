<?php


namespace CalderaLearn\RestSearch;

/**
 * Class ModifySchema
 *
 * Modifies the REST API route schema so it has an argument "post_type"
 *
 *
 * @package ExamplePlugin
 */
class ModifySchema implements ModifySchemaContract
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
	public function filterSchema($query_params, $post_type)
	{
		if ($this->shouldFilter($post_type)) {
			$query_params = array_merge($this->getArguments(), $query_params);
		}

		return $query_params;
	}

	/* @inheritdoc */
	public function shouldFilter(\WP_Post_Type $WP_Post_Type): bool
	{
		return PostType::SLUG === $WP_Post_Type->name;
	}
}
