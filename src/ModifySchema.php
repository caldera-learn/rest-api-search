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
class ModifySchema
{
	use UsesPreparedPostTypes;

	/**
	 * The name of the extra argument we are adding to post type routes
	 */
	const ARGNAME = 'post_type';

	/**
	 * Add post_type to schema
	 *
	 * @uses ""rest_{$postType}_collection_params" action
	 *
	 * @param array $query_params JSON Schema-formatted collection parameters.
	 * @param \WP_Post_Type $post_type Post type object.
	 *
	 * @return array
	 */
	public function filterSchema($query_params, $post_type)
	{
		if ($this->shouldFilter($post_type)) {
			$query_params[self::ARGNAME] = [
				'default' => PostType::RESTBASE,
				'description' => __('Post type(s) for search query'),
				'type' => 'array',
				//Limit to public post types and allow query by rest base
				'items' =>
					[
						'enum' => $this->preparedPostTypes->getPostTypeRestBases(),
						'type' => 'string',
					],
			];
		}

		return $query_params;
	}

	/**
	 * Check if this post type's schema should be filtered
	 *
	 * @param \WP_Post_Type $WP_Post_Type
	 * @return bool
	 */
	public function shouldFilter(\WP_Post_Type $WP_Post_Type): bool
	{
		return PostType::SLUG === $WP_Post_Type->name;
	}
}
